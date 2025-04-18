<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('cliente')->latest()->get();
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::where('stock', '>', 0)->get();
        return view('ventas.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'metodo_pago' => 'required|string',
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $venta = Venta::create([
                'cliente_id'   => $request->cliente_id,
                'fecha_venta'  => now(),
                'total'        => 0, // se calcula más abajo
                'metodo_pago'  => $request->metodo_pago,
                'vendedor_id'  => Auth::user()->id,
                'es_factura'   => true,
            ]);

            $total = 0;

            // Filtrar productos válidos (con cantidad mayor a 0)
            $productosFormateados = collect($request->productos)->filter(function ($item) {
                return isset($item['id'], $item['cantidad']) && $item['cantidad'] > 0;
            });

            foreach ($productosFormateados as $item) {
                $producto = Producto::findOrFail($item['id']);

                // 🚫 Validar stock suficiente
                if ($producto->stock < $item['cantidad']) {
                    DB::rollBack();
                    return back()->with('error', "No hay suficiente stock para el producto: {$producto->nombre} (Stock disponible: {$producto->stock})");
                }

                $subtotal = $producto->precio_venta * $item['cantidad'];

                DetalleVenta::create([
                    'venta_id'        => $venta->id,
                    'producto_id'     => $producto->id,
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $producto->precio_venta,
                    'subtotal'        => $subtotal,
                ]);

                $producto->decrement('stock', $item['cantidad']);

                $total += $subtotal;
            }

            $venta->update(['total' => $total]);

            DB::commit();

            return redirect()->route('ventas.index')->with('success', 'Venta realizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error en la venta: ' . $e->getMessage());
        }
    }


    public function show(Venta $venta)
    {
        $venta->load('detalles.producto', 'cliente', 'vendedor');
        return view('ventas.show', compact('venta'));
    }

    public function descargarFactura(Venta $venta)
    {
        $venta->load('detalles.producto', 'cliente', 'vendedor');

        $pdf = Pdf::loadView('ventas.factura_pdf', compact('venta'));

        return $pdf->download('Factura_Venta_' . $venta->id . '.pdf');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    public function index()
    {
        $facturas = Factura::with('cliente')->latest()->paginate(10);
        return view('facturas.index', compact('facturas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('facturas.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $isv = 0;
            $detalles = [];

            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['id']);

                if ($producto->stock < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para el producto: {$producto->nombre}");
                }

                $precio = $producto->precio_venta;
                $cantidad = $item['cantidad'];
                $subtotalProducto = $precio * $cantidad;

                $producto->decrement('stock', $cantidad);

                $detalles[] = [
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio,
                    'subtotal' => $subtotalProducto,
                ];

                $subtotal += $subtotalProducto;
            }

            $isv = round($subtotal * 0.15, 2);
            $total = $subtotal + $isv;

            $factura = Factura::create([
                'cliente_id' => $request->cliente_id,
                'usuario_id' => Auth::id(),
                'metodo_pago' => 'Efectivo',
                'subtotal' => $subtotal,
                'isv' => $isv,
                'total' => $total,
            ]);

            foreach ($detalles as $detalle) {
                $factura->detalles()->create($detalle);
            }

            DB::commit();
            return redirect()->route('facturas.show', $factura)->with('success', 'Factura generada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al generar la factura: ' . $e->getMessage());
        }
    }

    public function show(Factura $factura)
    {
        $factura->load('cliente', 'detalles.producto', 'usuario');
        return view('facturas.show', compact('factura'));
    }

    public function edit(Factura $factura)
    {
        abort(404); // No implementado
    }

    public function update(Request $request, Factura $factura)
    {
        abort(404); // No implementado
    }

    public function destroy(Factura $factura)
    {
        $factura->delete();
        return redirect()->route('facturas.index')->with('success', 'Factura eliminada.');
    }
}

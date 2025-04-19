<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\DetalleFactura;
use Illuminate\Support\Facades\Auth;
use App\Models\Reparacion;

class ReparacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reparaciones = \App\Models\Reparacion::with('cliente')->latest()->get();
        return view('reparaciones.index', compact('reparaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = \App\Models\Cliente::all();
        $tecnicos = \App\Models\User::all(); // Podés filtrar si usás roles

        return view('reparaciones.create', compact('clientes', 'tecnicos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'imei' => 'nullable|string|max:50',
            'falla_reportada' => 'required|string',
            'accesorios' => 'nullable|string',
            'tecnico_id' => 'required|exists:users,id',
            'fecha_ingreso' => 'required|date',
            'costo_total' => 'required|numeric|min:0',
            'abono' => 'nullable|numeric|min:0|max:' . $request->input('costo_total'),
        ]);

        \App\Models\Reparacion::create([
            'cliente_id' => $request->cliente_id,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'imei' => $request->imei,
            'falla_reportada' => $request->falla_reportada,
            'accesorios' => $request->accesorios,
            'tecnico_id' => $request->tecnico_id,
            'fecha_ingreso' => $request->fecha_ingreso,
            'costo_total' => $request->costo_total,
            'abono' => $request->abono ?? 0,
            'estado' => 'recibido',
        ]);

        return redirect()->route('reparaciones.index')->with('success', 'Reparación registrada correctamente.');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function facturar(Reparacion $reparacion)
    {
        if ($reparacion->factura_id) {
            return redirect()->back()->with('error', 'Ya ha sido facturada.');
        }

        $cliente = $reparacion->cliente;
        $cliente_id = $cliente ? $cliente->id : null;
        $subtotal = $reparacion->costo_total;
        $saldo_pendiente = $subtotal - $reparacion->abono;

        $factura = Factura::create([
            'cliente_id' => $cliente_id,
            'usuario_id' => Auth::id(),
            'metodo_pago' => 'Efectivo',
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'monto_recibido' => $saldo_pendiente,
            'cambio' => 0,
        ]);

        $factura->detalles()->create([
            'producto_id' => null,
            'cantidad' => 1,
            'precio_unitario' => $subtotal,
            'subtotal' => $subtotal,
            'descripcion' => "Reparación de {$reparacion->marca} {$reparacion->modelo}",
        ]);

        $reparacion->update([
            'factura_id' => $factura->id,
            'estado' => 'entregado',
        ]);

        return redirect()->route('facturas_reparaciones.show', $factura->id)
            ->with('success', 'Factura generada correctamente.');
    }


    public function abonar(Request $request, Reparacion $reparacion)
    {
        $request->validate([
            'nuevo_abono' => 'required|numeric|min:1',
        ]);

        $nuevoTotalAbono = $reparacion->abono + $request->nuevo_abono;

        if ($nuevoTotalAbono > $reparacion->costo_total) {
            return redirect()->back()->with('error', '⚠️ El abono excede el total de la reparación.');
        }

        $reparacion->abono = $nuevoTotalAbono;
        $reparacion->save();

        return redirect()->back()->with('success', '✅ Abono registrado correctamente.');
    }
}

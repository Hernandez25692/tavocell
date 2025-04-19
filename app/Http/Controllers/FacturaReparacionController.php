<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Reparacion;
use Barryvdh\DomPDF\Facade\Pdf;

class FacturaReparacionController extends Controller
{
    public function index()
    {
        // Cargamos las facturas Y sus reparaciones asociadas por 'factura_id'
        $facturas = Factura::with(['cliente', 'usuario', 'detalles'])
            ->whereHas('detalles', fn($q) => $q->whereNull('producto_id'))
            ->latest()
            ->get();

        // Obtenemos las reparaciones indexadas por factura_id
        $reparaciones = Reparacion::whereIn('factura_id', $facturas->pluck('id'))
            ->get()
            ->keyBy('factura_id');

        return view('facturas_reparaciones.index', compact('facturas', 'reparaciones'));
    }

    public function show(Factura $factura)
    {
        $factura->load('cliente', 'usuario', 'detalles');
        $reparacion = Reparacion::where('factura_id', $factura->id)->first();
        return view('facturas_reparaciones.show', compact('factura', 'reparacion'));
    }

    public function pdf(Factura $factura)
    {
        $factura->load('cliente', 'usuario', 'detalles');
        $reparacion = Reparacion::where('factura_id', $factura->id)->first();
        $pdf = Pdf::loadView('facturas_reparaciones.factura_pdf', compact('factura', 'reparacion'));
        return $pdf->stream("reparacion_{$factura->id}.pdf");
    }

    public function destroy(Factura $factura)
    {
        $reparacion = Reparacion::where('factura_id', $factura->id)->first();
        if ($reparacion) {
            $reparacion->update(['factura_id' => null, 'estado' => 'recibido']);
        }

        $factura->detalles()->delete();
        $factura->delete();

        return redirect()->route('facturas_reparaciones.index')->with('success', 'Factura eliminada y reparación restablecida.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CierreDiario;
use App\Models\Venta;
use Illuminate\Http\Request;
use App\Models\Factura;

class CierreDiarioController extends Controller
{
    public function index()
    {
        $cierres = CierreDiario::with('usuario')->latest()->get();
        return view('cierres.index', compact('cierres'));
    }

    public function store(Request $request)
    {
        $fechaHoy = now()->toDateString();

        // Evitar doble cierre
        if (CierreDiario::where('fecha', $fechaHoy)->exists()) {
            return back()->with('error', 'El cierre de hoy ya fue realizado.');
        }

        $ventasHoy = Factura::whereDate('created_at', $fechaHoy)->get();
        $totalVentas = $ventasHoy->sum('total');
        $totalReparaciones = Factura::whereDate('created_at', $fechaHoy)
            ->whereHas('detalles', fn($q) => $q->whereNull('producto_id')) // solo reparaciones
            ->sum('total');

        $cierre = CierreDiario::create([
            'fecha' => $fechaHoy,
            'total_ventas' => $totalVentas,
            'total_reparaciones' => $totalReparaciones,
            'total_efectivo' => $totalVentas + $totalReparaciones,
            'usuario_id' => \Illuminate\Support\Facades\Auth::user()->id,
        ]);

        return back()->with('success', 'Cierre del día realizado correctamente.');
    }
}

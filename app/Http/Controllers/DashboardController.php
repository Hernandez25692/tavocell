<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Reparacion;
use App\Models\SuscripcionNetflix;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function mostrar()
    {
        $hoy = Carbon::today();

        $ingresosProductos = Factura::whereDate('created_at', $hoy)->sum('total');
        $ingresosReparaciones = Reparacion::whereDate('created_at', $hoy)->sum('abono');
        $ingresosTotales = $ingresosProductos + $ingresosReparaciones;

        $totalFacturasHoy = Factura::whereDate('created_at', $hoy)->count();
        $reparacionesActivas = Reparacion::where('estado', '!=', 'Finalizado')->count();

        $ingresosPorDia = Factura::select(DB::raw("DATE(created_at) as fecha"), DB::raw("SUM(total) as total"))
            ->whereDate('created_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $suscripcionesProximas = SuscripcionNetflix::where('estado', 'activo')
            ->whereBetween('fecha_fin', [$hoy, $hoy->copy()->addDays(5)])
            ->with('cliente')
            ->get();

        return view('dashboard', compact(
            'ingresosTotales',
            'totalFacturasHoy',
            'reparacionesActivas',
            'ingresosPorDia',
            'suscripcionesProximas'
        ));
    }
}

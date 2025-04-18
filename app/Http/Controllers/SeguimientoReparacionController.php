<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use App\Models\SeguimientoReparacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeguimientoReparacionController extends Controller
{
    public function index(Reparacion $reparacion)
    {
        $reparacion->load('cliente', 'seguimientos.tecnico');

        return view('reparaciones.seguimiento', compact('reparacion'));
    }

    public function store(Request $request, Reparacion $reparacion)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'estado' => 'required|in:recibido,en_proceso,listo,entregado',
        ]);

        SeguimientoReparacion::create([
            'reparacion_id' => $reparacion->id,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado,
            'fecha_avance' => now(),
            'tecnico_id' => Auth::user()->id, // 👈 Esto elimina el warning
            'notificado' => false,
        ]);

        // Actualiza estado actual en la reparación
        $reparacion->update(['estado' => $request->estado]);

        return back()->with('success', 'Seguimiento actualizado correctamente.');
    }
}

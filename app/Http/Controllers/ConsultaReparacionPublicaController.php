<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;

class ConsultaReparacionPublicaController extends Controller
{
    public function ver($id)
    {
        $reparacion = Reparacion::with(['cliente', 'tecnico', 'seguimientos'])->findOrFail($id);

        return view('reparaciones.consulta_publica', compact('reparacion'));
    }

    public function publico($id)
    {
        $reparacion = \App\Models\Reparacion::with('cliente', 'seguimientos.imagenes')->findOrFail($id);
        return view('reparaciones.seguimiento_publico', compact('reparacion'));
    }
}

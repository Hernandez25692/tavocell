<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Reparacion;

class ConsultaReparacionController extends Controller
{
    public function index()
    {
        return view('publico.consulta');
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'identidad' => 'required|string',
        ]);

        $cliente = Cliente::where('telefono', $request->identidad)
                          ->orWhere('correo', $request->identidad)
                          ->first();

        if (!$cliente) {
            return back()->with('error', 'No se encontró ningún cliente con esos datos.');
        }

        $reparaciones = Reparacion::where('cliente_id', $cliente->id)
                                  ->with('seguimientos')
                                  ->latest()
                                  ->get();

        if ($reparaciones->isEmpty()) {
            return back()->with('error', 'No hay reparaciones asociadas al cliente.');
        }

        return view('publico.resultado', compact('cliente', 'reparaciones'));
    }
}

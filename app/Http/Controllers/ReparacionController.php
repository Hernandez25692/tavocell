<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}

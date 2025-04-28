<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\SuscripcionNetflix;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SuscripcionNetflixController extends Controller
{
    public function index()
    {
        // Actualizar automáticamente suscripciones vencidas
        $hoy = Carbon::today();

        // Buscar suscripciones que ya vencieron y aún están activas
        $suscripcionesVencidas = SuscripcionNetflix::where('fecha_fin', '<', $hoy)
            ->where('estado', 'activo')
            ->get();

        foreach ($suscripcionesVencidas as $suscripcion) {
            $suscripcion->estado = 'vencido';
            $suscripcion->save();
        }

        // Luego mostrar normalmente
        $suscripciones = SuscripcionNetflix::with('cliente')
            ->orderBy('fecha_fin', 'asc')
            ->paginate(10);

        return view('suscripciones_netflix.index', compact('suscripciones'));
    }


    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('suscripciones_netflix.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'monto' => 'required|numeric|min:0',
            'estado' => 'required|in:activo,vencido',
        ]);

        SuscripcionNetflix::create([
            'cliente_id' => $request->cliente_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'monto' => $request->monto,
            'estado' => $request->estado,  // ✅ Se toma el valor enviado correctamente
        ]);

        return redirect()->route('suscripciones-netflix.index')->with('success', 'Suscripción creada correctamente.');
    }


    public function edit($id)
    {
        $suscripcion = SuscripcionNetflix::with('cliente')->findOrFail($id); // ⚡ carga relación cliente de una vez
        $clientes = Cliente::orderBy('nombre')->get(); // solo por si quieres mostrar clientes (aunque esté deshabilitado)

        return view('suscripciones_netflix.edit', compact('suscripcion', 'clientes'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'monto' => 'required|numeric|min:0',
            'estado' => 'required|in:activo,vencido', // aquí ya corregido
        ]);

        $suscripcion = SuscripcionNetflix::findOrFail($id);

        $suscripcion->fecha_inicio = $request->fecha_inicio;
        $suscripcion->fecha_fin = $request->fecha_fin;
        $suscripcion->monto = $request->monto;
        $suscripcion->estado = $request->estado; // 🔥 fuerza guardar aunque venga de modal
        $suscripcion->save();

        return redirect()->route('suscripciones-netflix.index')->with('success', 'Suscripción actualizada correctamente.');
    }



    public function destroy(SuscripcionNetflix $suscripcion)
    {
        $suscripcion->delete();
        return redirect()->route('suscripciones-netflix.index')->with('success', 'Suscripción eliminada exitosamente.');
    }

    // Para futuras notificaciones automáticas de vencimiento
    public function alertas()
    {
        $hoy = Carbon::now();
        $suscripciones = SuscripcionNetflix::where('fecha_fin', '<=', $hoy->addDays(5))
            ->where('estado', 'activo')
            ->with('cliente')
            ->get();

        return view('suscripciones_netflix.alertas', compact('suscripciones'));
    }

    public function show($id)
    {
        $suscripcion = SuscripcionNetflix::with('cliente')->findOrFail($id);

        return view('suscripciones_netflix.show', compact('suscripcion'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use App\Models\SeguimientoReparacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReparacionListaMail;

class SeguimientoReparacionController extends Controller
{
    public function index(Reparacion $reparacion)
    {
        $reparacion->load('cliente', 'seguimientos.tecnico');

        return view('reparaciones.seguimiento', compact('reparacion'));
    }

    public function store(Request $request, Reparacion $reparacion)
    {
        $reparacion->load('cliente');
        $request->validate([
            'descripcion' => 'required|string',
            'estado' => 'required|in:recibido,en_proceso,listo,entregado',
        ]);

        $estado = $request->estado;
        $pendiente = $reparacion->costo_total - $reparacion->abono;

        // 🟡 Solo evitamos ENTREGAR si aún hay saldo pendiente
        if ($estado === 'entregado' && $pendiente > 0) {
            return back()->with('error', '⚠️ No puedes marcar esta reparación como "Entregado" hasta que el cliente haya pagado el total.');
        }

        SeguimientoReparacion::create([
            'reparacion_id' => $reparacion->id,
            'descripcion' => $request->descripcion,
            'estado' => $estado,
            'fecha_avance' => now(),
            'tecnico_id' => Auth::id(),
            'notificado' => false,
        ]);
        // 🟡 Enviamos un correo al cliente si la reparación está lista
        logger('🧪 Estado recibido: ' . $estado);
        logger('🧪 Cliente cargado: ' . json_encode($reparacion->cliente));

        if ($estado === 'listo' && $reparacion->cliente && $reparacion->cliente->correo) {
            logger('📧 Enviando correo a: ' . $reparacion->cliente->correo);

            try {
                Mail::to($reparacion->cliente->correo)->send(new ReparacionListaMail($reparacion));
                logger('✅ Correo enviado correctamente.');
            } catch (\Exception $e) {
                logger()->error('❌ Error al enviar correo: ' . $e->getMessage());
            }
        }


        // 🟡 Actualizamos el estado de la reparación
        $reparacion->update(['estado' => $estado]);

        return back()->with('success', '✅ Seguimiento actualizado correctamente.');
    }
}

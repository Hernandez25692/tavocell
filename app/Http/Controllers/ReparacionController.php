<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Models\Reparacion;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Milon\Barcode\DNS2D;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ReparacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Reparacion::with('cliente');

        // Filtro por cliente
        if ($request->filled('cliente')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->cliente . '%');
            });
        }
        if ($request->filled('identidad')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('identidad', 'like', '%' . $request->identidad . '%');
            });
        }
        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por fechas
        if ($request->filled('desde')) {
            $query->whereDate('fecha_ingreso', '>=', $request->desde);
        }
        if ($request->filled('hasta')) {
            $query->whereDate('fecha_ingreso', '<=', $request->hasta);
        }

        $reparaciones = $query->latest()->get();

        return view('reparaciones.index', compact('reparaciones'));
    }


    public function create()
    {
        $clientes = Cliente::all();
        $tecnicos = User::all(); // Puedes filtrar por rol
        return view('reparaciones.create', compact('clientes', 'tecnicos'));
    }

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

        // Crear la reparación
        $reparacion = Reparacion::create([
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

        // Generar código QR con la URL pública de seguimiento
        $qr = new \Milon\Barcode\DNS2D();
        $qr->setStorPath(storage_path('framework/qr'));
        $url = route('consulta.reparacion.publica', ['id' => $reparacion->id]);
        $qrData = $qr->getBarcodePNG($url, 'QRCODE');

        // Crear y guardar imagen física del QR
        $qrFileName = 'qr_' . $reparacion->id . '_' . \Illuminate\Support\Str::random(8) . '.png';
        $qrDir = public_path('storage/qr');
        $qrPath = $qrDir . '/' . $qrFileName;

        if (!\File::exists($qrDir)) {
            \File::makeDirectory($qrDir, 0755, true);
        }

        file_put_contents($qrPath, base64_decode($qrData));

        // Generar el PDF usando ruta local absoluta válida para DomPDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reparaciones.comprobante_pdf', [
            'reparacion' => $reparacion,
            'qrPath' => 'file://' . $qrPath
        ]);

        $pdfName = 'comprobante_' . $reparacion->id . '.pdf';
        Storage::disk('public')->put("comprobantes/{$pdfName}", $pdf->output());

        return redirect()->route('reparaciones.index')
            ->with('success', 'Reparación registrada correctamente.')
            ->with('comprobante', $pdfName);
    }


    public function facturar(Reparacion $reparacion)
    {
        if ($reparacion->factura_id) {
            return redirect()->back()->with('error', 'Ya ha sido facturada.');
        }

        $cliente_id = $reparacion->cliente?->id;
        $subtotal = $reparacion->costo_total;
        $saldo = $subtotal - $reparacion->abono;

        $factura = Factura::create([
            'cliente_id' => $cliente_id,
            'usuario_id' => Auth::id(),
            'metodo_pago' => 'Efectivo',
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'monto_recibido' => $saldo,
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

        $nuevoTotal = $reparacion->abono + $request->nuevo_abono;

        if ($nuevoTotal > $reparacion->costo_total) {
            return back()->with('error', '⚠️ El abono excede el total de la reparación.');
        }

        $reparacion->abono = $nuevoTotal;
        $reparacion->save();

        return back()->with('success', '✅ Abono registrado correctamente.');
    }

    // Métodos vacíos
    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}

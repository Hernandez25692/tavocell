@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">🔍 Estado de Reparación</h1>

    <div class="bg-white p-6 rounded-lg shadow-md border">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">📱 Equipo: {{ $reparacion->marca }} {{ $reparacion->modelo }}</h2>

        <p><strong>👤 Cliente:</strong> {{ $reparacion->cliente->nombre }}</p>
        <p><strong>📅 Ingreso:</strong> {{ $reparacion->fecha_ingreso }}</p>
        <p><strong>🛠️ Técnico:</strong> {{ $reparacion->tecnico->name }}</p>
        <p><strong>🧾 Estado Actual:</strong> <span class="font-bold">{{ strtoupper($reparacion->estado) }}</span></p>
        <p><strong>💬 Falla:</strong> {{ $reparacion->falla_reportada }}</p>
        <p><strong>🎒 Accesorios:</strong> {{ $reparacion->accesorios ?? 'Ninguno' }}</p>
        <p><strong>💰 Costo:</strong> L. {{ number_format($reparacion->costo_total, 2) }}</p>
        <p><strong>💵 Abono:</strong> L. {{ number_format($reparacion->abono, 2) }}</p>
        <p><strong>🧾 Saldo Pendiente:</strong> <span class="text-red-600 font-bold">L. {{ number_format($reparacion->costo_total - $reparacion->abono, 2) }}</span></p>
    </div>

    <div class="mt-6">
        <h3 class="text-lg font-semibold mb-2 text-gray-700">📋 Seguimiento:</h3>
        @forelse($reparacion->seguimientos as $item)
            <div class="mb-2 p-3 border-l-4 border-blue-500 bg-blue-50 rounded">
                <strong>{{ $item->fecha }}</strong> - {{ $item->descripcion }}
            </div>
        @empty
            <p class="text-gray-600">Sin actualizaciones todavía.</p>
        @endforelse
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">📋 Detalle de Ajuste de Inventario</h1>

    <div class="bg-white p-6 rounded-lg shadow border border-gray-200 space-y-4">
        <p><strong>Código:</strong> {{ $ajuste->codigo }}</p>
        <p><strong>Nombre:</strong> {{ $ajuste->nombre }}</p>
        <p><strong>Stock Sistema:</strong> {{ $ajuste->stock_sistema }}</p>
        <p><strong>Stock Físico:</strong> {{ $ajuste->stock_fisico }}</p>
        <p><strong>Diferencia:</strong> <span class="{{ $ajuste->diferencia < 0 ? 'text-red-600' : 'text-green-600' }}">{{ $ajuste->diferencia }}</span></p>
        <p><strong>Observaciones:</strong> {{ $ajuste->observaciones ?? 'Ninguna' }}</p>
        <p><strong>Fecha:</strong> {{ $ajuste->created_at->format('d/m/Y h:i A') }}</p>
    </div>

    <div class="mt-6">
        <a href="{{ route('ajustes-inventario.index') }}"
           class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded-lg shadow">
            ← Volver al Historial
        </a>
    </div>
</div>
@endsection

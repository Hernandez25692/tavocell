@extends('layouts.app')

@section('title', 'Seguimiento de Reparación')

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6 mt-8">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-blue-700 mb-1">🔧 Seguimiento de Reparación</h2>
            <p class="text-gray-600 text-sm">Reparación #{{ $reparacion->id }}</p>
        </div>

        <div class="border-t border-gray-200 my-4"></div>

        <div class="space-y-2 text-sm">
            <p><span class="font-semibold text-gray-700">👤 Cliente:</span>
                {{ $reparacion->cliente->nombre ?? 'Cliente no identificado' }}</p>
            <p><span class="font-semibold text-gray-700">📱 Dispositivo:</span> {{ $reparacion->marca }} -
                {{ $reparacion->modelo }}</p>
            @if ($reparacion->imei)
                <p><span class="font-semibold text-gray-700">🔢 IMEI:</span> {{ $reparacion->imei }}</p>
            @endif
            <p><span class="font-semibold text-gray-700">📅 Fecha de Ingreso:</span>
                {{ \Carbon\Carbon::parse($reparacion->fecha_ingreso)->format('d/m/Y') }}</p>
            <p><span class="font-semibold text-gray-700">📋 Estado actual:</span> <span
                    class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs uppercase tracking-wide">{{ $reparacion->estado }}</span>
            </p>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">📌 Historial de Seguimiento</h3>
            @forelse ($reparacion->seguimientos as $seg)
                <div class="bg-gray-50 p-3 rounded mb-2 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-800">{{ $seg->descripcion }}</p>
                    <p class="text-xs text-gray-500 text-right">{{ $seg->created_at->format('d/m/Y H:i') }}</p>
                </div>
            @empty
                <div class="bg-yellow-50 text-yellow-700 px-4 py-2 rounded shadow-sm">
                    No hay seguimientos registrados aún.
                </div>
            @endforelse
        </div>


    </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8 animate-fade-in">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">📄 Detalles de Suscripción Netflix</h1>

    <div class="bg-white p-6 rounded-lg shadow-lg space-y-6 border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Cliente:</h2>
                <p class="text-gray-800">{{ $suscripcion->cliente->nombre }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Estado:</h2>
                <p class="text-gray-800">
                    @if ($suscripcion->estado === 'activo')
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Activo</span>
                    @else
                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Vencido</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Fecha Inicio:</h2>
                <p class="text-gray-800">{{ \Carbon\Carbon::parse($suscripcion->fecha_inicio)->format('d/m/Y') }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Fecha Vencimiento:</h2>
                <p class="text-gray-800">{{ \Carbon\Carbon::parse($suscripcion->fecha_fin)->format('d/m/Y') }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Monto Pagado:</h2>
                <p class="text-gray-800">L. {{ number_format($suscripcion->monto, 2) }}</p>
            </div>
        </div>

        <div class="text-right">
            <a href="{{ route('suscripciones-netflix.index') }}" 
                class="inline-flex items-center px-5 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg text-sm font-medium">
                ← Volver al Historial
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
    .animate-fade-in {
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush
@endsection

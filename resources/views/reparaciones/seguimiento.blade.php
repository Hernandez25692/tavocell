@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10 animate-fade-in">
    <div class="max-w-5xl mx-auto space-y-10">

        <!-- ENCABEZADO -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">📱 Seguimiento de Reparación</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                <p><span class="font-semibold">👤 Cliente:</span> {{ $reparacion->cliente->nombre }}</p>
                <p><span class="font-semibold">📱 Dispositivo:</span> {{ $reparacion->marca }} {{ $reparacion->modelo }}</p>
                <p><span class="font-semibold">🔢 IMEI:</span> {{ $reparacion->imei ?? 'No registrado' }}</p>
                <p>
                    <span class="font-semibold">📍 Estado actual:</span>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold border shadow-sm
                        {{
                            match($reparacion->estado) {
                                'pendiente' => 'bg-red-100 text-red-700 border-red-400',
                                'en_proceso', 'en_proceso' => 'bg-yellow-100 text-yellow-800 border-yellow-400',
                                'listo' => 'bg-green-100 text-green-700 border-green-400',
                                'entregado' => 'bg-blue-100 text-blue-700 border-blue-400',
                                default => 'bg-gray-100 text-gray-700 border-gray-300'
                            }
                        }}">
                        {{ ucfirst(str_replace('_', ' ', $reparacion->estado)) }}
                    </span>
                </p>
            </div>
        </div>

        <!-- FORMULARIO DE AVANCE -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">📝 Nuevo Avance Técnico</h2>
            <form action="{{ route('seguimientos.store', $reparacion) }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción del avance:</label>
                    <textarea name="descripcion" required rows="3"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none shadow-sm"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado:</label>
                    <select name="estado" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm bg-white">
                        <option value="recibido">Recibido</option>
                        <option value="en_proceso">En proceso</option>
                        <option value="listo">Listo</option>
                        <option value="entregado">Entregado</option>
                    </select>
                </div>

                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition-all duration-200">
                    Guardar Avance
                </button>
            </form>
        </div>

        <!-- HISTORIAL DE AVANCES (TIMELINE) -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
            <h2 class="text-xl font-bold text-gray-800 mb-6">📋 Historial de Seguimiento</h2>
            <ul class="relative border-l-4 border-indigo-300 pl-6 space-y-6">
                @forelse($reparacion->seguimientos as $seg)
                    <li class="relative">
                        <div class="absolute -left-3 top-1 w-6 h-6 bg-indigo-500 rounded-full border-4 border-white shadow"></div>
                        <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 shadow-sm">
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span><strong>Fecha:</strong> {{ $seg->fecha_avance }}</span>
                                <span><strong>Estado:</strong> {{ ucfirst(str_replace('_', ' ', $seg->estado)) }}</span>
                            </div>
                            <p class="text-gray-800 mb-1"><strong>Técnico:</strong> {{ $seg->tecnico->name }}</p>
                            <p class="text-gray-700 text-sm">{{ $seg->descripcion }}</p>
                        </div>
                    </li>
                @empty
                    <li class="text-gray-500 italic">No hay avances registrados aún.</li>
                @endforelse
            </ul>
        </div>

        <!-- BOTÓN VOLVER -->
        <div class="text-right">
            <a href="{{ route('reparaciones.index') }}"
               class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-lg font-medium shadow-sm transition">
                ← Volver a la lista
            </a>
        </div>

    </div>
</div>

@push('styles')
<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush
@endsection

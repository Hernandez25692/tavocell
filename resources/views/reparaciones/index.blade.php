@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 animate-fade-in">
        <div class="max-w-6xl mx-auto space-y-6">

            <div class="flex justify-between items-center mb-4">
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                    🛠️ Reparaciones Registradas
                </h1>
                <a href="{{ route('reparaciones.create') }}"
                    class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Nueva Reparación
                </a>
            </div>

            <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
                <table class="min-w-full table-auto text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-3">Cliente</th>
                            <th class="px-6 py-3">Dispositivo</th>
                            <th class="px-6 py-3">Falla</th>
                            <th class="px-6 py-3">Estado</th>
                            <th class="px-6 py-3">Ingreso</th>
                            <th class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($reparaciones as $rep)
                            <tr class="hover:bg-gray-50 border-t">
                                <td class="px-6 py-4">{{ $rep->cliente->nombre }}</td>
                                <td class="px-6 py-4">{{ $rep->marca }} {{ $rep->modelo }}</td>
                                <td class="px-6 py-4">{{ $rep->falla_reportada }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-xs font-bold border shadow-sm
    {{ match ($rep->estado) {
        'pendiente' => 'bg-red-100 text-red-700 border-red-400',
        'en_proceso' => 'bg-yellow-100 text-yellow-800 border-yellow-400',
        'listo' => 'bg-green-100 text-green-700 border-green-400',
        'entregado' => 'bg-blue-100 text-blue-700 border-blue-400',
        default => 'bg-gray-100 text-gray-700 border-gray-300',
    } }}">
                                        {{ ucfirst(str_replace('_', ' ', $rep->estado)) }}
                                    </span>

                                </td>
                                <td class="px-6 py-4">{{ $rep->fecha_ingreso }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('seguimientos.index', $rep->id) }}"
                                        class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 font-medium transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Seguimiento
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    @push('styles')
        <style>
            .animate-fade-in {
                animation: fadeIn 0.5s ease-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    @endpush
@endsection

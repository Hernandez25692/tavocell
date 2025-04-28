@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 animate-fade-in">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">🎟️ Historial de Suscripciones Netflix</h1>
            <a href="{{ route('suscripciones-netflix.create') }}"
                class="inline-flex items-center px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow">
                ➕ Nueva Suscripción
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            @if ($suscripciones->isEmpty())
                <div class="text-center p-6 text-gray-500">
                    No hay suscripciones registradas aún.
                </div>
            @else
                <table class="min-w-full table-auto text-sm text-gray-800">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left">Cliente</th>
                            <th class="px-4 py-3 text-left">Fecha Inicio</th>
                            <th class="px-4 py-3 text-left">Fecha Fin</th>
                            <th class="px-4 py-3 text-left">Monto</th>
                            <th class="px-4 py-3 text-center">Estado</th>
                            <th class="px-4 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suscripciones as $suscripcion)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $suscripcion->cliente->nombre }}</td>
                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::parse($suscripcion->fecha_inicio)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($suscripcion->fecha_fin)->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3">L. {{ number_format($suscripcion->monto, 2) }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if ($suscripcion->estado === 'activo')
                                        <span
                                            class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                            ✅ Activo
                                        </span>
                                    @else
                                        <div class="flex flex-col items-center">
                                            <span
                                                class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold mb-1">
                                                ❌ Vencido
                                            </span>
                                            <span class="text-xs text-red-600 font-bold animate-pulse">
                                                ¡Suscripción vencida!
                                            </span>
                                        </div>
                                    @endif

                                </td>
                                <td class="px-4 py-3 flex justify-center gap-2">
                                    <a href="{{ route('suscripciones-netflix.show', $suscripcion->id) }}"
                                        class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded text-xs font-medium">
                                        👁️ Ver
                                    </a>
                                    <a href="{{ route('suscripciones-netflix.edit', $suscripcion) }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs font-medium">
                                        ✏️ Editar
                                    </a>
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-4">
                    {{ $suscripciones->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('styles')
        <style>
            .animate-fade-in {
                animation: fadeIn 0.4s ease-out;
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

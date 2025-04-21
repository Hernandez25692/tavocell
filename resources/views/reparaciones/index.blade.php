@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 animate-fade-in">
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Encabezado y botón -->
        <div class="flex justify-between items-center flex-wrap gap-4">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                🛠️ Reparaciones Registradas
            </h1>
            <a href="{{ route('reparaciones.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition-all">
                + Nueva Reparación
            </a>
        </div>

        <!-- Filtros -->
        <form method="GET" action="{{ route('reparaciones.index') }}" class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="cliente" value="{{ request('cliente') }}" placeholder="🔍 Buscar cliente..."
                    class="border-gray-300 rounded-md shadow-sm w-full">

                <select name="estado" class="border-gray-300 rounded-md shadow-sm w-full">
                    <option value="">Todos los estados</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="en_proceso" {{ request('estado') == 'en_proceso' ? 'selected' : '' }}>En proceso</option>
                    <option value="listo" {{ request('estado') == 'listo' ? 'selected' : '' }}>Listo</option>
                    <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                </select>

                <input type="date" name="desde" value="{{ request('desde') }}"
                    class="border-gray-300 rounded-md shadow-sm w-full" placeholder="Desde">

                <input type="date" name="hasta" value="{{ request('hasta') }}"
                    class="border-gray-300 rounded-md shadow-sm w-full" placeholder="Hasta">
            </div>

            <div class="flex justify-end mt-4 gap-2">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium shadow">
                    Aplicar filtros
                </button>
                <a href="{{ route('reparaciones.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md font-medium shadow">
                    Limpiar
                </a>
            </div>
        </form>

        <!-- Tabla -->
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
                    @forelse ($reparaciones as $rep)
                        <tr class="hover:bg-gray-50 border-t">
                            <td class="px-6 py-4">{{ $rep->cliente->nombre }}</td>
                            <td class="px-6 py-4">{{ $rep->marca }} {{ $rep->modelo }}</td>
                            <td class="px-6 py-4">{{ $rep->falla_reportada }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold border shadow-sm
                                    {{ match($rep->estado) {
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
                                    class="text-indigo-600 hover:text-indigo-800 font-medium transition">
                                    📋 Seguimiento
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500 italic">No se encontraron resultados.</td>
                        </tr>
                    @endforelse
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

    @if (session('comprobante'))
        <iframe id="comprobante-frame" src="{{ asset('storage/comprobantes/' . session('comprobante')) }}"
            style="display:none;"></iframe>
        <script>
            window.onload = function() {
                const link = document.createElement('a');
                link.href = "{{ asset('storage/comprobantes/' . session('comprobante')) }}";
                link.download = "{{ session('comprobante') }}";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        </script>
    @endif
@endsection

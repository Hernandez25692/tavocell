@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 animate-fade-in">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📋 Historial de Ajustes de Inventario</h1>
        <a href="{{ route('ajustes-inventario.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow transition">
            ➕ Nuevo Ajuste
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($ajustes->isEmpty())
        <div class="bg-white shadow rounded-lg p-6 text-center text-gray-500">
            No hay ajustes registrados todavía.
        </div>
    @else
        <div class="overflow-x-auto bg-white shadow rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3">Fecha</th>
                        <th class="px-6 py-3">Código</th>
                        <th class="px-6 py-3">Producto</th>
                        <th class="px-6 py-3 text-right">Stock Sistema</th>
                        <th class="px-6 py-3 text-right">Stock Físico</th>
                        <th class="px-6 py-3 text-center">Diferencia</th>
                        <th class="px-6 py-3 text-center">Responsable</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-800">
                    @foreach($ajustes as $ajuste)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $ajuste->created_at->format('d/m/Y h:i A') }}</td>
                            <td class="px-6 py-4 font-mono">{{ $ajuste->codigo }}</td>
                            <td class="px-6 py-4">{{ $ajuste->nombre }}</td>
                            <td class="px-6 py-4 text-right">{{ $ajuste->stock_sistema }}</td>
                            <td class="px-6 py-4 text-right">{{ $ajuste->stock_fisico }}</td>
                            <td class="px-6 py-4 text-center font-bold {{ $ajuste->diferencia < 0 ? 'text-red-600' : ($ajuste->diferencia > 0 ? 'text-green-600' : 'text-gray-600') }}">
                                {{ $ajuste->diferencia }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $ajuste->usuario ? $ajuste->usuario->name : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('ajustes-inventario.show', $ajuste->id) }}"
                                    class="bg-indigo-500 hover:bg-indigo-600 text-white text-xs font-semibold px-4 py-2 rounded-full shadow transition">
                                    Ver
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-4">
                {{ $ajustes->links() }}
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush
@endsection

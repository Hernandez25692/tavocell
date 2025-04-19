@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">

        <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            📄 Historial de Facturas
        </h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4 flex items-center gap-2 shadow">
                <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="mb-6">
            <a href="{{ route('facturas.create') }}"
               class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition-all">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4" />
                </svg>
                Nueva Factura
            </a>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
            <table class="min-w-full table-auto text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Fecha</th>
                        <th class="px-6 py-3">Cliente</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($facturas as $factura)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $factura->id }}</td>
                            <td class="px-6 py-4">{{ $factura->fecha_factura }}</td>
                            <td class="px-6 py-4">{{ $factura->cliente->nombre ?? 'Consumidor Final' }}</td>
                            <td class="px-6 py-4 font-bold text-green-700">L. {{ number_format($factura->total, 2) }}</td>
                            <td class="px-6 py-4 text-center flex gap-2 justify-center">
                                <a href="{{ route('facturas.show', $factura->id) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm shadow">
                                    Ver
                                </a>
                                <a href="{{ route('facturas.pdf', $factura->id) }}"
                                   class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm shadow">
                                    PDF
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No hay facturas registradas aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">

        <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            📅 Cierres Diarios
        </h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4 flex items-center gap-2 shadow">
                <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @elseif(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-4 flex items-center gap-2 shadow">
                <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('cierres.store') }}" class="mb-6">
            @csrf
            <button type="submit"
                class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition-all">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3M16 7V3M4 11h16M4 19h16M4 15h16" />
                </svg>
                Realizar Cierre de Hoy
            </button>
        </form>

        <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
            <table class="min-w-full table-auto text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3">Fecha</th>
                        <th class="px-6 py-3">Total Ventas</th>
                        <th class="px-6 py-3">Total Reparaciones</th>
                        <th class="px-6 py-3">Total Efectivo</th>
                        <th class="px-6 py-3">Responsable</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($cierres as $cierre)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $cierre->fecha }}</td>
                            <td class="px-6 py-4">L. {{ number_format($cierre->total_ventas, 2) }}</td>
                            <td class="px-6 py-4">L. {{ number_format($cierre->total_reparaciones, 2) }}</td>
                            <td class="px-6 py-4 font-bold text-green-700">L. {{ number_format($cierre->total_efectivo, 2) }}</td>
                            <td class="px-6 py-4">{{ $cierre->usuario->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

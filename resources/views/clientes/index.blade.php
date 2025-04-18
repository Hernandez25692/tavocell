@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 animate-fade-in">
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Encabezado -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-800 flex items-center gap-2">
                    👤 Lista de Clientes
                </h1>
            </div>
            <a href="{{ route('clientes.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow transition">
                + Nuevo Cliente
            </a>
        </div>

        <!-- Mensaje de éxito -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabla de clientes -->
        <div class="overflow-x-auto bg-white shadow rounded-lg border border-gray-200">
            <table class="min-w-full text-sm text-left divide-y divide-gray-200">
                <thead class="bg-gray-100 text-xs font-semibold text-gray-700 uppercase">
                    <tr>
                        <th class="px-6 py-3">Nombre</th>
                        <th class="px-6 py-3">Identidad</th>
                        <th class="px-6 py-3">Teléfono</th>
                        <th class="px-6 py-3">Correo</th>
                        <th class="px-6 py-3">Dirección</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-800">
                    @foreach($clientes as $cliente)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->nombre }}</td>
                            <td class="px-6 py-4">{{ $cliente->identidad }}</td>
                            <td class="px-6 py-4">{{ $cliente->telefono }}</td>
                            <td class="px-6 py-4">{{ $cliente->correo }}</td>
                            <td class="px-6 py-4">{{ $cliente->direccion }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('clientes.edit', $cliente) }}"
                                       class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm font-medium">
                                        ✏️
                                    </a>
                                    <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" onsubmit="return confirm('¿Eliminar cliente?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm font-medium">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $clientes->links('pagination::tailwind') }}
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

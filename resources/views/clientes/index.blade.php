@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 px-4 py-8 animate-fade-in">
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Encabezado -->
            <div
                class="flex justify-between items-center flex-wrap gap-4 p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <span class="bg-indigo-100 p-3 rounded-full text-indigo-600 shadow-inner">👤</span>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">Lista de
                        Clientes</span>
                </h1>
                <a href="{{ route('clientes.create') }}"
                    class="relative overflow-hidden group bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    + Nuevo Cliente
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Filtro de búsqueda -->
            <form method="GET" action="{{ route('clientes.index') }}" class="mb-6">
                <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
                    <input type="text" name="identidad" value="{{ request('identidad') }}"
                        class="px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition"
                        placeholder="Buscar por identidad...">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition shadow">
                        🔍 Buscar
                    </button>
                    @if (request('identidad'))
                        <a href="{{ route('clientes.index') }}" class="text-sm text-gray-500 hover:underline ml-2">
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>

            <!-- Tabla -->
            <div
                class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 transition-all duration-300 hover:shadow-xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Identidad
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Teléfono</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Correo</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Dirección
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($clientes as $index => $cliente)
                                <tr class="transition-all duration-200 hover:bg-indigo-50/50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $clientes->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">
                                        {{ $cliente->nombre }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $cliente->identidad }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $cliente->telefono }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $cliente->correo }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $cliente->direccion }}</td>
                                    <td class="px-6 py-4 text-sm text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('clientes.edit', $cliente) }}"
                                                class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm font-medium shadow">
                                                ✏️
                                            </a>
                                            <form action="{{ route('clientes.destroy', $cliente) }}" method="POST"
                                                onsubmit="return confirm('¿Eliminar cliente?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm font-medium shadow">
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
            </div>

            <!-- Paginación -->
            <div class="flex items-center justify-between pt-4">
                <div class="text-sm text-gray-600">
                    Mostrando <span class="font-medium">{{ $clientes->firstItem() }}</span> a
                    <span class="font-medium">{{ $clientes->lastItem() }}</span> de
                    <span class="font-medium">{{ $clientes->total() }}</span> resultados
                </div>
                <div class="flex space-x-1">
                    {{ $clientes->withQueryString()->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .animate-fade-in {
                animation: fadeIn 0.5s ease-out forwards;
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

            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb {
                background: #c7d2fe;
                border-radius: 10px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #a5b4fc;
            }
        </style>
    @endpush
@endsection

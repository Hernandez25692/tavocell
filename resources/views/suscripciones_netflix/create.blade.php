@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8 animate-fade-in">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">➕ Nueva Suscripción Netflix</h1>

        @if (session('success'))
            <div
                class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6 border border-green-300 flex items-center animate-pulse">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-6 border border-red-300">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('suscripciones-netflix.store') }}" method="POST"
            class="bg-white p-6 rounded-lg shadow-lg space-y-6 border border-gray-200">
            @csrf

            <div>
                <label class="block mb-1 font-semibold text-gray-700">Cliente</label>
                <select name="cliente_id" required
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                    <option value="">-- Selecciona un cliente --</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Fecha de Inicio</label>
                    <input type="date" name="fecha_inicio" required
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Fecha de Vencimiento</label>
                    <input type="date" name="fecha_fin" required
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-700">Monto (Lempiras)</label>
                <input type="number" name="monto" step="0.01" min="1" required
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block mb-1 font-semibold text-gray-700">Estado</label>
                <select name="estado" required
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                    <option value="activo">Activo</option>
                    <option value="vencido">Vencido</option>
                </select>
            </div>


            <div class="text-right pt-4">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow transition-all">
                    💾 Guardar Suscripción
                </button>
            </div>
        </form>
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

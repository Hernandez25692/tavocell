@extends('layouts.app')

@section('content')
<div class="container max-w-lg mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4 text-indigo-700">{{ isset($cliente) ? 'Editar Cliente' : 'Nuevo Cliente' }}</h1>

    <form action="{{ isset($cliente) ? route('clientes.update', $cliente) : route('clientes.store') }}" method="POST">
        @csrf
        @if(isset($cliente)) @method('PUT') @endif

        <div class="mb-4">
            <label class="block font-semibold mb-1">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre ?? '') }}" class="w-full rounded border-gray-300" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Identidad</label>
            <input type="text" name="identidad" value="{{ old('identidad', $cliente->identidad ?? '') }}" class="w-full rounded border-gray-300" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono ?? '') }}" class="w-full rounded border-gray-300">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Correo</label>
            <input type="email" name="correo" value="{{ old('correo', $cliente->correo ?? '') }}" class="w-full rounded border-gray-300">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Dirección</label>
            <input type="text" name="direccion" value="{{ old('direccion', $cliente->direccion ?? '') }}" class="w-full rounded border-gray-300">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                {{ isset($cliente) ? 'Actualizar' : 'Guardar' }}
            </button>
        </div>
    </form>
</div>
@endsection

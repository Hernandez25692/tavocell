@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">👥 Gestión de Usuarios</h1>
        <a href="{{ route('usuarios.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow">
            + Nuevo Usuario
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow-md rounded-lg border border-gray-200">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-left">Correo</th>
                    <th class="px-6 py-3 text-left">Rol</th>
                    <th class="px-6 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-gray-800">
                @foreach($usuarios as $usuario)
                <tr>
                    <td class="px-6 py-4">{{ $usuario->name }}</td>
                    <td class="px-6 py-4">{{ $usuario->email }}</td>
                    <td class="px-6 py-4">
                        {{ $usuario->roles->pluck('name')->join(', ') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="text-indigo-600 hover:underline mr-3">Editar</a>
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Deseas eliminar este usuario?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

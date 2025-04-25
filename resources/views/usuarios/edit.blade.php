@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-lg">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">✏️ Editar Usuario</h1>

    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow border border-gray-200">
        @csrf @method('PUT')

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $usuario->name) }}" required class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Correo Electrónico</label>
            <input type="email" name="email" value="{{ old('email', $usuario->email) }}" required class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Rol</label>
            <select name="role" required class="w-full px-4 py-2 border rounded-lg">
                @foreach($roles as $rol)
                    <option value="{{ $rol }}" {{ $usuario->roles->first()->name === $rol ? 'selected' : '' }}>
                        {{ ucfirst($rol) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="text-right">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection

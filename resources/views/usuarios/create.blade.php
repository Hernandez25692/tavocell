@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-lg">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">➕ Crear Usuario</h1>

    <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow border border-gray-200">
        @csrf

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Nombre</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Correo Electrónico</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Contraseña</label>
            <input type="password" name="password" required class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" required class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Rol</label>
            <select name="role" required class="w-full px-4 py-2 border rounded-lg">
                <option value="">Selecciona un rol</option>
                @foreach($roles as $rol)
                    <option value="{{ $rol }}">{{ ucfirst($rol) }}</option>
                @endforeach
            </select>
        </div>

        <div class="text-right">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">
                Crear Usuario
            </button>
        </div>
    </form>
</div>
@endsection

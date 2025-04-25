@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-lg animate-fade-in">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">✏️ Editar Usuario</h1>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST"
          class="space-y-5 bg-white p-6 rounded-xl shadow-md border border-gray-200" autocomplete="off">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $usuario->name) }}" required
                   class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Correo Electrónico</label>
            <input type="email" name="email" value="{{ old('email', $usuario->email) }}" required
                   class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                   autocomplete="off">
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Rol</label>
            <select name="role" required
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                @foreach($roles as $rol)
                    <option value="{{ $rol }}" {{ $usuario->roles->first()->name === $rol ? 'selected' : '' }}>
                        {{ ucfirst($rol) }}
                    </option>
                @endforeach
            </select>
        </div>

        <hr class="my-4">

        <h2 class="text-lg font-semibold text-gray-700">🔐 Cambiar Contraseña (opcional)</h2>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Nueva Contraseña</label>
            <div class="relative">
                <input type="password" id="password" name="password" minlength="8"
                       class="w-full px-4 py-2 border rounded-lg pr-10 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                       autocomplete="new-password">
                <button type="button" onclick="togglePassword('password')"
                        class="absolute right-3 top-2 text-gray-500 hover:text-indigo-600 text-sm">👁️</button>
            </div>
            <small class="text-xs text-gray-500">Dejar vacío si no desea cambiarla.</small>
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Confirmar Nueva Contraseña</label>
            <div class="relative">
                <input type="password" id="password_confirmation" name="password_confirmation" minlength="8"
                       class="w-full px-4 py-2 border rounded-lg pr-10 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                       autocomplete="new-password">
                <button type="button" onclick="togglePassword('password_confirmation')"
                        class="absolute right-3 top-2 text-gray-500 hover:text-indigo-600 text-sm">👁️</button>
            </div>
        </div>

        <div class="text-right pt-4">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow-md transition">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
@endpush

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

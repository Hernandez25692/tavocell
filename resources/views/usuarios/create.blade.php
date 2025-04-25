@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-lg animate-fade-in">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">➕ Crear Usuario</h1>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ traducirError($error) }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('usuarios.store') }}" method="POST"
          class="space-y-5 bg-white p-6 rounded-xl shadow-md border border-gray-200" autocomplete="off">
        @csrf

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Nombre</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                   autocomplete="off">
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Correo Electrónico</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                   autocomplete="off">
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Contraseña</label>
            <div class="relative">
                <input type="password" id="password" name="password" required minlength="8"
                       class="w-full px-4 py-2 border rounded-lg shadow-sm pr-10 focus:ring-indigo-500 focus:border-indigo-500"
                       autocomplete="new-password">
                <button type="button" onclick="togglePassword('password')"
                        class="absolute right-3 top-2 text-gray-500 hover:text-indigo-600 text-sm">👁️</button>
            </div>
            <small class="text-xs text-gray-500">Debe contener al menos 8 caracteres.</small>
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Confirmar Contraseña</label>
            <div class="relative">
                <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8"
                       class="w-full px-4 py-2 border rounded-lg shadow-sm pr-10 focus:ring-indigo-500 focus:border-indigo-500"
                       autocomplete="new-password">
                <button type="button" onclick="togglePassword('password_confirmation')"
                        class="absolute right-3 top-2 text-gray-500 hover:text-indigo-600 text-sm">👁️</button>
            </div>
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Rol</label>
            <select name="role" required
                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                <option value="">Selecciona un rol</option>
                @foreach($roles as $rol)
                    <option value="{{ $rol }}" {{ old('role') == $rol ? 'selected' : '' }}>
                        {{ ucfirst($rol) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="text-right">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow-md transition">
                Crear Usuario
            </button>
        </div>
    </form>
</div>

<!-- Toast de éxito -->
@if(session('success'))
    <div x-data="{ show: true }" x-show="show"
         x-init="setTimeout(() => show = false, 4000)"
         class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded shadow-lg z-50">
        ✅ {{ session('success') }}
    </div>
@endif

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
        animation: fadeIn 0.5s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush
@endsection

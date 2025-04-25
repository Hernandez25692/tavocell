@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-xl animate-fade-in">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">👤 Mi Perfil</h1>

    @if (session('status'))
        <div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-5 bg-white p-6 rounded-xl shadow-md border border-gray-200">
        @csrf
        @method('PATCH')

        <div>
            <label class="block font-semibold text-gray-700 mb-1">Nombre</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                   class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label class="block font-semibold text-gray-700 mb-1">Correo electrónico</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                   class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label class="block font-semibold text-gray-700 mb-1">Rol asignado</label>
            <input type="text" value="{{ auth()->user()->roles->pluck('name')->join(', ') }}"
                   class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-gray-700 shadow-sm" disabled>
        </div>

        <div class="text-right">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow transition">
                Guardar Cambios
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
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush
@endsection

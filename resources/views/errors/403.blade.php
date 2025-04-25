@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 px-4 py-12">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-red-600 mb-4">403</h1>
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Acceso Denegado</h2>
        <p class="text-gray-600 mb-6">No tienes permiso para acceder a esta sección del sistema.</p>
        <a href="{{ route('dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow">
            Volver al Dashboard
        </a>
    </div>
</div>
@endsection

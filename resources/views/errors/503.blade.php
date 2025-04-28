@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
    <h1 class="text-6xl font-bold text-yellow-500 mb-4">503</h1>
    <p class="text-2xl font-semibold text-gray-800 mb-2">Servicio no disponible</p>
    <p class="text-gray-600 text-center max-w-md mb-6">
        Estamos en mantenimiento o el sistema está temporalmente fuera de servicio. Vuelve a intentarlo pronto.
    </p>
    <a href="{{ route('dashboard') }}"
       class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg">
        ⬅️ Volver al Inicio
    </a>
</div>
@endsection

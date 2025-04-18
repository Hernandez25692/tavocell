@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-xl font-bold mb-4">🔍 Consultar estado de reparación</h1>

    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('consulta.buscar') }}" class="bg-white p-4 rounded shadow">
        @csrf
        <label for="identidad" class="block font-medium mb-2">Ingrese su número de teléfono o correo registrado:</label>
        <input type="text" name="identidad" class="form-control mb-3" required>
        <button class="btn btn-primary">Consultar</button>
    </form>
</div>
@endsection

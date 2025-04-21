@extends('layouts.app')

@section('content')
<div class="form-container">
    <h1 class="form-title">
        <i class="fas fa-user-plus"></i>
        {{ isset($cliente) ? 'Editar Cliente' : 'Nuevo Cliente' }}
    </h1>

    <form action="{{ isset($cliente) ? route('clientes.update', $cliente) : route('clientes.store') }}" method="POST" class="client-form">
        @csrf
        @if(isset($cliente)) @method('PUT') @endif

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $cliente->nombre ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="identidad">Identidad</label>
            <input type="text" id="identidad" name="identidad" value="{{ old('identidad', $cliente->identidad ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $cliente->telefono ?? '') }}">
        </div>

        <div class="form-group">
            <label for="correo">Correo</label>
            <input type="email" id="correo" name="correo" value="{{ old('correo', $cliente->correo ?? '') }}">
        </div>

        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $cliente->direccion ?? '') }}">
        </div>

        <div class="form-actions">
            <button type="submit" class="button primary">
                <i class="fas fa-save"></i>
                {{ isset($cliente) ? 'Actualizar' : 'Guardar' }}
            </button>
            <a href="{{ route('clientes.index') }}" class="button secondary">
                <i class="fas fa-times"></i>
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection

<style>
    .form-container {
        max-width: 500px; /* Ajustado para un tamaño productivo no muy grande */
        margin: 30px auto;
        padding: 25px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-title {
        font-size: 2rem;
        font-weight: bold;
        color: #4c6ef5; /* Un tono de indigo */
        margin-bottom: 25px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .form-title i {
        font-size: 2.2rem;
    }

    .client-form {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 8px;
        color: #374151; /* Tailwind gray-700 */
    }

    .form-group input[type="text"],
    .form-group input[type="email"] {
        padding: 10px;
        border: 1px solid #d1d5db; /* Tailwind gray-300 */
        border-radius: 6px;
        font-size: 1rem;
        color: #4b5563; /* Tailwind gray-500 */
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="email"]:focus {
        outline: none;
        border-color: #6366f1; /* Tailwind indigo-500 */
        box-shadow: 0 0 0 0.2rem rgba(129, 140, 248, 0.25); /* Tailwind indigo-200 */
    }

    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 25px;
        justify-content: flex-end;
    }

    .button {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .button.primary {
        background-color: #4c6ef5; /* Un tono de indigo */
        color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .button.primary:hover {
        background-color: #3b82f6; /* Tailwind blue-500 */
    }

    .button.secondary {
        background-color: #e5e7eb; /* Tailwind gray-200 */
        color: #374151; /* Tailwind gray-700 */
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .button.secondary:hover {
        background-color: #d1d5db; /* Tailwind gray-300 */
    }

    .button i {
        font-size: 1.1rem;
    }

    /* Responsive adjustments */
    @media (max-width: 600px) {
        .form-container {
            margin: 20px;
            padding: 20px;
        }

        .form-title {
            font-size: 1.75rem;
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 0.9rem;
        }

        .form-group input[type="text"],
        .form-group input[type="email"] {
            padding: 9px;
            font-size: 0.9rem;
        }

        .form-actions {
            gap: 10px;
            margin-top: 20px;
        }

        .button {
            padding: 8px 16px;
            font-size: 0.9rem;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
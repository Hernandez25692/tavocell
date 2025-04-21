@extends('layouts.app')

@section('content')
<div class="edit-client-container">
    <div class="page-header">
        <h1><i class="fas fa-pencil-alt"></i> Editar Cliente</h1>
        <p class="subtitle">Modifica la información del cliente.</p>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('clientes.update', $cliente) }}" class="edit-client-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre"><i class="fas fa-user"></i> Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ $cliente->nombre }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="identidad"><i class="fas fa-id-card"></i> Identidad</label>
                <input type="text" id="identidad" name="identidad" value="{{ $cliente->identidad }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="telefono"><i class="fas fa-phone"></i> Teléfono</label>
                <input type="text" id="telefono" name="telefono" value="{{ $cliente->telefono }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="correo"><i class="fas fa-envelope"></i> Correo</label>
                <input type="email" id="correo" name="correo" value="{{ $cliente->correo }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="direccion"><i class="fas fa-map-marker-alt"></i> Dirección</label>
                <textarea id="direccion" name="direccion" class="form-control">{{ $cliente->direccion }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary update-btn"><i class="fas fa-save"></i> Actualizar</button>
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary cancel-btn"><i class="fas fa-times"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

<style>
    /* Variables de diseño */
    :root {
        --primary-color: #007bff;
        --primary-dark: #0056b3;
        --secondary-color: #6c757d;
        --light-color: #f8f9fa;
        --dark-color: #343a40;
        --text-color: #495057;
        --border-color: #dee2e6;
        --box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        --border-radius: 0.3rem;
        --transition: all 0.3s ease-in-out;
        --font-family-base: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        font-family: var(--font-family-base);
        background-color: var(--light-color);
        color: var(--text-color);
        line-height: 1.6;
        margin: 0;
        padding: 0;
    }

    .edit-client-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 1.5rem;
    }

    .page-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .page-header h1 {
        font-size: 2rem;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .page-header h1 i {
        margin-right: 0.5rem;
    }

    .page-header .subtitle {
        color: var(--secondary-color);
        font-size: 1rem;
    }

    .form-card {
        background-color: #fff;
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
    }

    .edit-client-form .form-group {
        margin-bottom: 1.5rem;
    }

    .edit-client-form label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: var(--dark-color);
        display: flex;
        align-items: center;
    }

    .edit-client-form label i {
        margin-right: 0.5rem;
        color: var(--primary-color);
    }

    .edit-client-form .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        font-size: 1rem;
        transition: border-color var(--transition), box-shadow var(--transition);
    }

    .edit-client-form .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .edit-client-form textarea.form-control {
        min-height: 100px;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        border: none;
        display: inline-flex;
        align-items: center;
    }

    .btn i {
        margin-right: 0.5rem;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: #fff;
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
    }

    .btn-secondary {
        background-color: var(--secondary-color);
        color: #fff;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .edit-client-container {
            padding: 1rem;
        }

        .page-header h1 {
            font-size: 1.75rem;
        }

        .form-actions {
            flex-direction: column;
            width: 100%;
        }

        .form-actions .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
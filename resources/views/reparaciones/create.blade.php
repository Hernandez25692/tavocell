@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 animate-fade-in">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md space-y-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            🛠️ Registrar Nueva Reparación
        </h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded relative">
                <strong>¡Error!</strong> Revisa los campos obligatorios o inválidos.
            </div>
        @endif

        <form action="{{ route('reparaciones.store') }}" method="POST" class="space-y-5" onsubmit="return validarAbono();">
            @csrf

            <!-- Cliente -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cliente <span class="text-red-500">*</span></label>
                <select name="cliente_id" required class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Seleccionar cliente</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Marca y Modelo -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Marca <span class="text-red-500">*</span></label>
                    <input type="text" name="marca" required class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Modelo <span class="text-red-500">*</span></label>
                    <input type="text" name="modelo" required class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            <!-- IMEI -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">IMEI (opcional)</label>
                <input type="text" name="imei" class="w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <!-- Falla Reportada -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Falla Reportada <span class="text-red-500">*</span></label>
                <textarea name="falla_reportada" rows="3" required class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
            </div>

            <!-- Accesorios -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Accesorios Entregados</label>
                <input type="text" name="accesorios" class="w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <!-- Técnico -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Técnico Asignado <span class="text-red-500">*</span></label>
                <select name="tecnico_id" required class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Seleccionar técnico</option>
                    @foreach ($tecnicos as $tecnico)
                        <option value="{{ $tecnico->id }}">{{ $tecnico->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Fecha Ingreso -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Ingreso <span class="text-red-500">*</span></label>
                <input type="date" name="fecha_ingreso" required value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <!-- Costo Total y Abono -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Costo Total (L.) <span class="text-red-500">*</span></label>
                    <input type="number" name="costo_total" id="costo_total" step="0.01" required class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Abono Inicial (L.)</label>
                    <input type="number" name="abono" id="abono" step="0.01" value="0" class="w-full border-gray-300 rounded-md shadow-sm">
                    <p id="error-abono" class="text-red-600 text-sm mt-1 hidden">⚠️ El abono no puede ser mayor al total.</p>
                </div>
            </div>

            <!-- Botón -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition">
                    Registrar Reparación
                </button>
            </div>
        </form>
    </div>
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

@push('scripts')
<script>
    function validarAbono() {
        const total = parseFloat(document.getElementById('costo_total').value || 0);
        const abono = parseFloat(document.getElementById('abono').value || 0);
        const mensaje = document.getElementById('error-abono');

        if (abono > total) {
            mensaje.classList.remove('hidden');
            return false;
        }

        mensaje.classList.add('hidden');
        return true;
    }
</script>
@endpush
@endsection

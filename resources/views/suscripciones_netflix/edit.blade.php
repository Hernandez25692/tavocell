@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8 animate-fade-in">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 flex items-center gap-2">
            ✏️ Editar Suscripción Netflix
        </h1>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow">
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="form-editar-suscripcion" action="{{ route('suscripciones-netflix.update', $suscripcion) }}" method="POST"
            class="bg-white p-8 rounded-lg shadow-lg space-y-6 border border-gray-200">


            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Cliente:</label>
                <select disabled class="w-full form-input bg-gray-100 cursor-not-allowed">
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}"
                            {{ $cliente->id == $suscripcion->cliente_id ? 'selected' : '' }}>
                            {{ $cliente->nombre }}
                        </option>
                    @endforeach
                </select>
                <small class="text-xs text-gray-500">* No se puede cambiar el cliente asociado.</small>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha de Inicio:</label>
                    <input type="date" name="fecha_inicio"
                        value="{{ old('fecha_inicio', \Carbon\Carbon::parse($suscripcion->fecha_inicio)->format('Y-m-d')) }}"
                        class="form-input w-full">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha de Vencimiento:</label>
                    <input type="date" name="fecha_fin"
                        value="{{ old('fecha_fin', \Carbon\Carbon::parse($suscripcion->fecha_fin)->format('Y-m-d')) }}"
                        class="form-input w-full">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Monto (Lempiras):</label>
                <input type="number" name="monto" value="{{ old('monto', $suscripcion->monto) }}" step="0.01"
                    min="1" required class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Estado:</label>
                <select name="estado" required class="form-input w-full">
                    <option value="activo" {{ $suscripcion->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="vencido" {{ $suscripcion->estado == 'vencido' ? 'selected' : '' }}>Vencido</option>
                </select>
            </div>

            <div class="flex justify-end pt-6">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition">
                    💾 Guardar Cambios
                </button>
            </div>

        </form>
    </div>

    <!-- Modal de confirmación -->
    <div id="modal-confirmacion" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-8 shadow-lg text-center space-y-6 w-full max-w-md">
            <h2 class="text-xl font-bold text-gray-800">¿Confirmar actualización?</h2>
            <p class="text-gray-600 text-sm">¿Estás seguro de guardar los cambios en esta suscripción?</p>
            <div class="flex justify-center gap-4 pt-4">
                <button onclick="cerrarModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Cancelar
                </button>
                <button onclick="document.getElementById('form-editar-suscripcion').submit()"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                    Sí, Guardar
                </button>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .form-input {
                padding: 0.5rem;
                border: 1px solid #d1d5db;
                border-radius: 0.375rem;
            }

            .form-input:focus {
                outline: none;
                border-color: #6366f1;
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
            }

            .animate-fade-in {
                animation: fadeIn 0.5s ease-in-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            function confirmarActualizar() {
                document.getElementById('modal-confirmacion').classList.remove('hidden');
            }

            function cerrarModal() {
                document.getElementById('modal-confirmacion').classList.add('hidden');
            }
        </script>
    @endpush
@endsection

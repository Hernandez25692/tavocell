@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Encabezado -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">📦 Gestión de Inventario</h1>
            <p class="text-gray-500">Administra los productos disponibles en TavoCell 504</p>
        </div>
        <a href="{{ route('productos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow flex items-center transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nuevo Producto
        </a>
    </div>

    <!-- Mensaje de éxito -->
    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded shadow mb-4 border-l-4 border-green-500 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Tabla de productos -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white">
                <tr>
                    <th class="px-6 py-3 text-left">Código</th>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-left">Stock</th>
                    <th class="px-6 py-3 text-left">Precio Venta</th>
                    <th class="px-6 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($productos as $producto)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $producto->codigo }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $producto->nombre }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full 
                                {{ $producto->stock < 5 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $producto->stock }} unidades
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-900 font-semibold">L. {{ number_format($producto->precio_venta, 2) }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('productos.edit', $producto) }}" class="bg-blue-100 text-blue-700 px-3 py-1 rounded hover:bg-blue-200 transition">
                                    ✏️ Editar
                                </a>
                                <button onclick="confirmDelete('{{ $producto->nombre }}', '{{ route('productos.destroy', $producto) }}')" 
                                        class="bg-red-100 text-red-700 px-3 py-1 rounded hover:bg-red-200 transition">
                                    🗑️ Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de confirmación -->
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 shadow-xl animate-fade-in">
        <h3 class="text-lg font-bold text-gray-800 mb-2" id="modalTitle">Confirmar Eliminación</h3>
        <p class="text-gray-600 mb-4" id="modalMessage">¿Estás seguro de eliminar este producto?</p>
        <div class="flex justify-end space-x-3">
            <button type="button" onclick="closeModal()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">Cancelar</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.2s ease-out;
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete(nombre, deleteUrl) {
        document.getElementById('modalTitle').innerText = `Eliminar "${nombre}"`;
        document.getElementById('modalMessage').innerText = `¿Estás seguro de eliminar el producto "${nombre}"? Esta acción no se puede deshacer.`;

        const form = document.getElementById('deleteForm');
        form.action = deleteUrl;

        const modal = document.getElementById('confirmModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('confirmModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>
@endpush

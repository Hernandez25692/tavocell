@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 animate-fade-in">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">➕ Nuevo Ajuste de Inventario</h1>

        <form action="{{ route('ajustes-inventario.store') }}" method="POST" id="form-ajuste">
            @csrf

            <div id="ajustes-container" class="space-y-4">
                <!-- Aquí se agregan dinámicamente los productos -->
            </div>

            <div class="flex gap-4 mt-6">
                <button type="button" onclick="agregarProducto()"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                    ➕ Agregar Producto
                </button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg">
                    💾 Guardar Ajuste
                </button>
            </div>
        </form>
    </div>

    <script>
        let index = 0;
        let productos = @json($productos);

        function agregarProducto() {
            const container = document.getElementById('ajustes-container');

            const div = document.createElement('div');
            div.classList.add('p-4', 'bg-white', 'rounded', 'shadow', 'border', 'relative');
            div.setAttribute('id', `producto-${index}`);

            div.innerHTML = `
            <button type="button" onclick="eliminarProducto(${index})"
                class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">
                &times;
            </button>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">Código:</label>
                    <input type="text" name="ajustes[${index}][codigo]" class="form-input w-full" oninput="buscarProducto(this, ${index})" required autocomplete="off">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Nombre:</label>
                    <input type="text" id="nombre-${index}" class="form-input w-full bg-gray-100" disabled>
                    <input type="hidden" name="ajustes[${index}][nombre]" id="nombre-hidden-${index}">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Stock Sistema:</label>
                    <input type="number" id="stock-sistema-${index}" class="form-input w-full bg-gray-100" disabled>
                    <input type="hidden" name="ajustes[${index}][stock_sistema]" id="stock-sistema-hidden-${index}">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Stock Físico:</label>
                    <input type="number" name="ajustes[${index}][stock_fisico]" class="form-input w-full" required min="0">
                </div>
            </div>
            <div class="mt-2">
                <label class="block text-sm font-semibold mb-1">Observaciones (opcional):</label>
                <input type="text" name="ajustes[${index}][observaciones]" class="form-input w-full">
            </div>
        `;

            container.appendChild(div);
            index++;
        }

        function eliminarProducto(idx) {
            const producto = document.getElementById(`producto-${idx}`);
            if (producto) {
                producto.remove();
            }
        }

        function buscarProducto(input, idx) {
            const codigo = input.value.trim();
            const producto = productos.find(p => p.codigo === codigo);

            if (producto) {
                document.getElementById(`nombre-${idx}`).value = producto.nombre;
                document.getElementById(`nombre-hidden-${idx}`).value = producto.nombre;
                document.getElementById(`stock-sistema-${idx}`).value = producto.stock;
                document.getElementById(`stock-sistema-hidden-${idx}`).value = producto.stock;
            } else {
                document.getElementById(`nombre-${idx}`).value = '';
                document.getElementById(`nombre-hidden-${idx}`).value = '';
                document.getElementById(`stock-sistema-${idx}`).value = '';
                document.getElementById(`stock-sistema-hidden-${idx}`).value = '';
            }
        }

        window.onload = function() {
            agregarProducto();
        };
    </script>

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
@endsection

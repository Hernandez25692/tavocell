@extends('layouts.app')

@section('content')
    <div class="container max-w-6xl mx-auto p-6">
        <!-- Card principal con efecto neumorfismo -->
        <div class="bg-white rounded-2xl shadow-2xl p-6 transform transition-all duration-300 hover:shadow-3xl">
            <!-- Encabezado con gradiente -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-4 rounded-xl mb-6">
                <h1 class="text-3xl font-bold flex items-center gap-3">
                    <span class="icon-cart animate-pulse">🛒</span>
                    <span class="text-shadow">Crear Factura de Productos</span>
                </h1>
            </div>

            <!-- Alertas personalizadas -->
            @if (session('error'))
                <div class="alert-error mb-6 animate-bounce-in" role="alert">
                    <div class="flex items-center">
                        <div class="py-1">
                            <svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path
                                    d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 5h2v6H9V5zm0 8h2v2H9v-2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">Error en la operación</p>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form id="factura-form" method="POST" action="{{ route('facturas_productos.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="metodo_pago" value="Efectivo">
                <input type="hidden" name="total" id="total-hidden">
                <input type="hidden" name="productos" id="productos-json">
                <input type="hidden" name="monto_recibido" id="monto-recibido-hidden">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Sección Cliente -->
                    <div class="space-y-6">
                        <!-- Card Buscar Cliente -->
                        <div
                            class="bg-gradient-to-br from-gray-50 to-white p-5 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <label class="block text-sm font-medium mb-2 text-gray-700">Buscar Cliente por Identidad</label>
                            <input type="text" id="buscar-identidad"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition"
                                placeholder="0801...">
                            <select name="cliente_id" id="cliente_id"
                                class="mt-3 w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition">
                                <option value="">-- Seleccionar cliente --</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" data-identidad="{{ $cliente->identidad }}">
                                        {{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Card Buscar Producto Compacto -->
                        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm space-y-3">
                            <h2 class="text-base font-semibold text-gray-700">🔎 Agregar Producto</h2>

                            <!-- Código de Barras -->
                            <label class="block text-sm font-medium text-gray-600">Código de Barras</label>
                            <div class="flex gap-2">
                                <input type="text" id="codigo-producto"
                                    class="flex-grow px-3 py-1.5 rounded-md border border-gray-300 focus:ring-1 focus:ring-indigo-300 focus:border-indigo-400 text-sm"
                                    placeholder="Escanear o escribir código">
                                <button type="button" onclick="buscarProducto()"
                                    class="px-3 py-1.5 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700 transition">
                                    Buscar
                                </button>
                            </div>

                            <!-- Buscar por nombre -->
                            <label class="block text-sm font-medium text-gray-600">Buscar por nombre</label>
                            <input type="text" id="nombre-producto"
                                class="w-full px-3 py-1.5 rounded-md border border-gray-300 focus:ring-1 focus:ring-indigo-300 focus:border-indigo-400 text-sm"
                                placeholder="Ej. Teclado gamer">
                            <div id="sugerencias-productos"
                                class="hidden mt-2 border border-gray-200 rounded-md bg-white shadow-lg max-h-48 overflow-y-auto z-50 absolute w-80">
                            </div>
                        </div>

                        <!-- Card Consulta Precio Compacto -->
                        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm space-y-3">
                            <h2 class="text-base font-semibold text-gray-700">💲 Consultar Precio</h2>

                            <div class="flex gap-2">
                                <input type="text" id="codigo-consulta"
                                    class="flex-grow px-3 py-1.5 rounded-md border border-gray-300 focus:ring-1 focus:ring-indigo-300 focus:border-indigo-400 text-sm"
                                    placeholder="Ej. 00123">
                                <button type="button" onclick="consultarPrecio()"
                                    class="px-3 py-1.5 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700 transition">
                                    Consultar
                                </button>
                            </div>

                            <!-- Resultado consulta -->
                            <div id="resultado-consulta" class="hidden border-t pt-3 text-sm space-y-1 text-gray-700">
                                <p><strong>Código:</strong> <span id="codigo-resultado"></span></p>
                                <p><strong>Nombre:</strong> <span id="nombre-resultado"></span></p>
                                <p><strong>Precio:</strong> L. <span id="precio-resultado"></span></p>
                                <button type="button" onclick="agregarProductoConsultado()"
                                    class="mt-2 px-3 py-1.5 bg-green-600 text-white rounded-md text-sm hover:bg-green-700 transition">
                                    ➕ Agregar al Carrito
                                </button>
                            </div>
                        </div>


                    </div>

                    <!-- Sección Productos y Resumen -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Tabla de Productos -->
                        <div class="overflow-x-auto border border-gray-200 rounded-xl shadow-sm">
                            <table class="min-w-full text-sm divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-semibold">
                                    <tr>
                                        <th class="p-3 text-left rounded-tl-xl">Código</th>
                                        <th class="p-3 text-left">Nombre</th>
                                        <th class="p-3 text-left">Precio</th>
                                        <th class="p-3 text-left">Cantidad</th>
                                        <th class="p-3 text-left">Subtotal</th>
                                        <th class="p-3 text-left rounded-tr-xl">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla-productos" class="divide-y divide-gray-100 text-gray-800">
                                    <!-- Productos se añadirán aquí dinámicamente -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Card Resumen -->
                        <div
                            class="bg-gradient-to-br from-gray-50 to-white p-5 rounded-xl border border-gray-100 shadow-md">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">Resumen de Factura</h3>
                                <p id="total-pagar" class="text-2xl font-bold text-green-600 animate-pulse">L. 0.00</p>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <!-- Botón Limpiar Carrito -->
                                <button type="button" onclick="limpiarCarrito()"
                                    class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transform hover:scale-105 transition flex items-center gap-2 shadow-lg">
                                    🗑 Limpiar Carrito
                                </button>

                                <button type="button" onclick="mostrarResumen()"
                                    class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition flex items-center gap-2 shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Facturar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal de Confirmación -->
        <div id="modal-pago"
            class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50 p-4 backdrop-blur-sm">
            <div
                class="bg-white p-6 rounded-2xl shadow-2xl max-w-md w-full transform transition-all duration-300 animate-modal-in">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-indigo-700">Resumen de Factura</h2>
                    <button onclick="cerrarModal()" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div id="resumen-productos" class="text-sm mb-4 max-h-48 overflow-y-auto space-y-2"></div>

                <div class="bg-blue-50 p-4 rounded-lg mb-4">
                    <p class="text-lg font-bold flex justify-between">
                        <span>Total:</span>
                        <span id="resumen-total" class="text-green-600">L. 0.00</span>
                    </p>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Monto recibido:</label>
                        <input type="number" id="monto-recibido"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition"
                            oninput="actualizarCambio()">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cambio:</label>
                        <input type="text" id="monto-cambio" readonly
                            class="w-full px-4 py-2 rounded-lg bg-gray-100 font-bold text-green-600 border border-gray-300">
                    </div>
                </div>

                <div id="mensaje-error" class="alert-error mt-3 hidden" role="alert">
                    <div class="flex items-center">
                        <svg class="fill-current h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>El monto recibido es menor al total</span>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button onclick="cerrarModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transform hover:scale-105 transition">
                        Cancelar
                    </button>
                    <button onclick="confirmarPago()"
                        class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:from-green-600 hover:to-emerald-700 transform hover:scale-105 transition shadow-md">
                        Confirmar Pago
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            /* Animaciones personalizadas */
            @keyframes pulse {
                0% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.05);
                }

                100% {
                    transform: scale(1);
                }
            }

            @keyframes bounce-in {
                0% {
                    transform: scale(0.8);
                    opacity: 0;
                }

                50% {
                    transform: scale(1.05);
                }

                100% {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            @keyframes modal-in {
                0% {
                    transform: translateY(20px) scale(0.95);
                    opacity: 0;
                }

                100% {
                    transform: translateY(0) scale(1);
                    opacity: 1;
                }
            }

            /* Estilos personalizados */
            .animate-pulse {
                animation: pulse 2s infinite;
            }

            .animate-bounce-in {
                animation: bounce-in 0.5s ease-out;
            }

            .animate-modal-in {
                animation: modal-in 0.3s ease-out;
            }

            .icon-cart {
                display: inline-block;
                animation: pulse 1.5s infinite, swing 3s ease-in-out infinite;
            }

            @keyframes swing {

                0%,
                100% {
                    transform: rotate(-5deg);
                }

                50% {
                    transform: rotate(5deg);
                }
            }

            @keyframes shake {

                0%,
                100% {
                    transform: translateX(0);
                }

                25% {
                    transform: translateX(-4px);
                }

                50% {
                    transform: translateX(4px);
                }

                75% {
                    transform: translateX(-4px);
                }
            }

            .text-shadow {
                text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
            }

            .alert-error {
                background-color: #fef2f2;
                border-left: 4px solid #f87171;
                color: #b91c1c;
                padding: 1rem;
                border-radius: 0.375rem;
            }

            .shadow-3xl {
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            /* Estilos para la tabla */
            #tabla-productos tr:hover {
                background-color: #f8fafc;
                transform: scale(1.002);
            }

            #tabla-productos input[type="number"] {
                border: 1px solid #e2e8f0;
                border-radius: 0.375rem;
                padding: 0.25rem 0.5rem;
                text-align: center;
            }

            #tabla-productos input[type="number"]:focus {
                outline: none;
                ring: 2px;
                ring-color: #a5b4fc;
            }

            /* Estilos para las sugerencias de productos */
            #sugerencias-productos div {
                padding: 0.75rem 1rem;
                transition: all 0.2s;
            }

            #sugerencias-productos div:hover {
                background-color: #f3f4f6;
                transform: translateX(2px);
            }

            /* Efecto de transición para botones */
            .transition {
                transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
                transition-duration: 150ms;
            }

            /* Scrollbar personalizado */
            ::-webkit-scrollbar {
                width: 8px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb {
                background: #c7d2fe;
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #a5b4fc;
            }
        </style>
    @endpush

    <script>
        const productos = @json($productos);
        const clientes = @json($clientes);
        let carrito = [];

        // Restaurar carrito desde localStorage si existe
        if (localStorage.getItem('carrito_tavocell')) {
            try {
                carrito = JSON.parse(localStorage.getItem('carrito_tavocell'));
                renderTabla(); // volver a dibujar la tabla al cargar
            } catch (e) {
                console.error('Error al cargar carrito desde localStorage:', e);
                carrito = [];
            }
        }

        // Evitar recarga accidental con Enter si hay productos en el carrito
        window.addEventListener('keydown', function(event) {
            const esEnter = event.key === 'Enter';
            const esInputText = ['INPUT', 'TEXTAREA'].includes(event.target.tagName);
            const tipo = event.target.getAttribute('type');
            const esTexto = !tipo || ['text', 'search'].includes(tipo);

            if (esEnter && esInputText && esTexto && carrito.length > 0) {
                event.preventDefault();
                event.stopPropagation();
                console.warn('⚠️ Recarga evitada por protección del carrito');
            }
        });

        // Al presionar Enter en el campo de código, se ejecuta buscarProducto()
        document.getElementById('codigo-producto').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // 🚫 evita recargar o limpiar
                buscarProducto(); // ✅ ejecuta la función de búsqueda
            }
        });

        function limpiarCarrito() {
            if (confirm('¿Estás seguro de limpiar toda la factura?')) {
                carrito = [];
                localStorage.removeItem('carrito_tavocell');
                renderTabla();
            }
        }

        document.getElementById('buscar-identidad').addEventListener('input', function() {
            const identidad = this.value.trim();
            const select = document.getElementById('cliente_id');
            for (let option of select.options) {
                if (option.dataset.identidad === identidad) {
                    select.value = option.value;
                    // Efecto visual al encontrar cliente
                    select.classList.add('ring-2', 'ring-green-500');
                    setTimeout(() => {
                        select.classList.remove('ring-2', 'ring-green-500');
                    }, 1000);
                    break;
                }
            }
        });

        document.getElementById('nombre-producto').addEventListener('input', function() {
            const termino = this.value.toLowerCase();
            const contenedor = document.getElementById('sugerencias-productos');
            if (termino.length < 2) return contenedor.classList.add('hidden');

            const resultados = productos.filter(p => p.nombre.toLowerCase().includes(termino)).slice(0, 5);
            contenedor.innerHTML = resultados.map(p =>
                `<div class="px-4 py-2 cursor-pointer hover:bg-indigo-50 transition flex justify-between items-center" 
              onclick="seleccionarProducto('${p.codigo}')">
            <span>${p.nombre}</span>
            <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded">${p.codigo}</span>
        </div>`
            ).join('');
            contenedor.classList.remove('hidden');
        });

        function seleccionarProducto(codigo) {
            document.getElementById('codigo-producto').value = codigo;
            document.getElementById('sugerencias-productos').classList.add('hidden');
            buscarProducto();
        }

        function buscarProducto() {
            const codigo = document.getElementById('codigo-producto').value.trim();
            const producto = productos.find(p => p.codigo === codigo);

            if (!producto) {
                const alertaId = 'modal-error-producto-' + Date.now();
                const modal = document.createElement('div');
                modal.id = alertaId;
                modal.className =
                    'fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-[9999] animate-fade-in';

                modal.innerHTML = `
        <div class="bg-white max-w-sm w-full rounded-xl shadow-2xl p-6 text-center animate-modal-in">
            <div class="text-red-600 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">¡Producto no encontrado!</h2>
            <p class="text-sm text-gray-600 mb-4">Verifica el código o intenta con otro producto.</p>
            <button onclick="document.getElementById('${alertaId}').remove()"
                class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition transform hover:scale-105">
                Cerrar
            </button>
        </div>
    `;

                document.body.appendChild(modal);

                const input = document.getElementById('codigo-producto');
                input.classList.add('ring-2', 'ring-red-500', 'animate-shake');
                setTimeout(() => {
                    input.classList.remove('ring-2', 'ring-red-500', 'animate-shake');
                }, 1000);
                return;
            }



            const existente = carrito.find(p => p.id === producto.id);
            if (existente) {
                existente.cantidad += 1;
                // Efecto visual de actualización
                document.getElementById('codigo-producto').classList.add('ring-2', 'ring-green-500');
                setTimeout(() => {
                    document.getElementById('codigo-producto').classList.remove('ring-2', 'ring-green-500');
                }, 500);
            } else {
                carrito.push({
                    id: producto.id,
                    codigo: producto.codigo,
                    nombre: producto.nombre,
                    precio: parseFloat(producto.precio_venta),
                    cantidad: 1
                });
                // Efecto visual de nuevo producto
                document.getElementById('codigo-producto').classList.add('ring-2', 'ring-blue-500');
                setTimeout(() => {
                    document.getElementById('codigo-producto').classList.remove('ring-2', 'ring-blue-500');
                }, 500);
            }

            document.getElementById('codigo-producto').value = '';
            renderTabla();
            localStorage.setItem('carrito_tavocell', JSON.stringify(carrito));

        }

        let productoConsultado = null;

        function consultarPrecio() {
            const codigo = document.getElementById('codigo-consulta').value.trim();
            const producto = productos.find(p => p.codigo === codigo);

            if (!producto) {
                const alertaId = 'modal-consulta-noencontrado-' + Date.now();
                const modal = document.createElement('div');
                modal.id = alertaId;
                modal.className =
                    'fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-[9999] animate-fade-in';

                modal.innerHTML = `
        <div class="bg-white max-w-sm w-full rounded-xl shadow-2xl p-6 text-center animate-modal-in">
            <div class="text-yellow-500 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h2 class="text-lg font-bold text-gray-800 mb-2">Producto no encontrado</h2>
            <p class="text-sm text-gray-600 mb-4">El código ingresado no corresponde a ningún producto en el sistema.</p>
            <button onclick="document.getElementById('${alertaId}').remove()"
                class="px-5 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition transform hover:scale-105">
                Entendido
            </button>
        </div>
    `;

                document.body.appendChild(modal);

                document.getElementById('resultado-consulta').classList.add('hidden');
                productoConsultado = null;
                return;
            }


            productoConsultado = producto;
            document.getElementById('codigo-resultado').textContent = producto.codigo;
            document.getElementById('nombre-resultado').textContent = producto.nombre;
            document.getElementById('precio-resultado').textContent = parseFloat(producto.precio_venta).toFixed(2);
            document.getElementById('resultado-consulta').classList.remove('hidden');
        }

        function agregarProductoConsultado() {
            if (!productoConsultado) return;

            const existente = carrito.find(p => p.id === productoConsultado.id);
            if (existente) {
                existente.cantidad += 1;
            } else {
                carrito.push({
                    id: productoConsultado.id,
                    codigo: productoConsultado.codigo,
                    nombre: productoConsultado.nombre,
                    precio: parseFloat(productoConsultado.precio_venta),
                    cantidad: 1
                });
            }

            renderTabla();
            localStorage.setItem('carrito_tavocell', JSON.stringify(carrito));
            mostrarAlerta('success', 'Producto agregado al carrito');

            // Limpiar
            document.getElementById('codigo-consulta').value = '';
            document.getElementById('resultado-consulta').classList.add('hidden');
            productoConsultado = null;
        }

        function renderTabla() {
            const tbody = document.getElementById('tabla-productos');
            tbody.innerHTML = '';
            let total = 0;

            if (carrito.length === 0) {
                tbody.innerHTML = `
        <tr>
            <td colspan="6" class="p-4 text-center text-gray-500">
                No hay productos agregados
            </td>
        </tr>`;
            } else {
                carrito.forEach((p, i) => {
                    const subtotal = p.precio * p.cantidad;
                    total += subtotal;

                    tbody.innerHTML += `
            <tr class="transition hover:bg-gray-50">
                <td class="p-3 font-mono">${p.codigo}</td>
                <td class="p-3">${p.nombre}</td>
                <td class="p-3 font-medium">L. ${p.precio.toFixed(2)}</td>
                <td class="p-3">
                    <input type="number" min="1" value="${p.cantidad}" 
                           class="w-16 text-center" 
                           onchange="actualizarCantidad(${i}, this.value)">
                </td>
                <td class="p-3 font-medium text-green-600">L. ${subtotal.toFixed(2)}</td>
                <td class="p-3">
                    <button onclick="eliminarProducto(${i})" 
                            class="text-red-500 hover:text-red-700 transition transform hover:scale-125">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </td>
            </tr>`;
                });
            }

            document.getElementById('total-pagar').textContent = 'L. ' + total.toFixed(2);
            document.getElementById('total-hidden').value = total.toFixed(2);
            document.getElementById('productos-json').value = JSON.stringify(carrito);

            // Animación al actualizar total
            const totalElement = document.getElementById('total-pagar');
            totalElement.classList.add('animate-pulse');
            setTimeout(() => {
                totalElement.classList.remove('animate-pulse');
            }, 1000);
        }

        function actualizarCantidad(i, val) {
            const newVal = Math.max(1, parseInt(val) || 1);
            carrito[i].cantidad = newVal;
            renderTabla();
        }

        function eliminarProducto(i) {
            carrito.splice(i, 1);
            localStorage.setItem('carrito_tavocell', JSON.stringify(carrito));
            renderTabla();
            mostrarAlerta('success', 'Producto eliminado del carrito');
        }

        function limpiarCarrito() {
            // Mostrar un modal de confirmación centrado
            const id = 'confirmar-limpiar-' + Date.now();
            const modal = document.createElement('div');
            modal.id = id;
            modal.className = `
        fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999] animate-fade-in
    `;
            modal.innerHTML = `
        <div class="bg-white max-w-sm w-full rounded-xl shadow-2xl p-6 text-center animate-modal-in">
            <h2 class="text-lg font-bold text-gray-800 mb-2">¿Estás seguro?</h2>
            <p class="text-sm text-gray-600 mb-4">Se eliminarán todos los productos de la factura actual.</p>
            <div class="flex justify-center gap-4">
                <button onclick="document.getElementById('${id}').remove()"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition transform hover:scale-105">
                    Cancelar
                </button>
                <button onclick="ejecutarLimpiezaCarrito('${id}')"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition transform hover:scale-105">
                    Sí, limpiar
                </button>
            </div>
        </div>
    `;
            document.body.appendChild(modal);
        }

        function ejecutarLimpiezaCarrito(id) {
            carrito = [];
            localStorage.removeItem('carrito_tavocell');
            renderTabla();
            mostrarAlerta('warning', 'Factura vaciada');
            document.getElementById(id).remove();
        }





        function mostrarResumen() {
            if (!carrito.length) {
                // Crear modal centrado profesional cuando no hay productos
                const id = 'alerta-sin-productos-' + Date.now();
                const modal = document.createElement('div');
                modal.id = id;
                modal.className =
                    'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999] animate-fade-in';
                modal.innerHTML = `
            <div class="bg-white max-w-sm w-full rounded-2xl shadow-2xl p-6 text-center animate-modal-in">
                <div class="flex justify-center items-center mb-4 text-red-600">
                    <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h2 class="text-lg font-bold">¡Atención!</h2>
                </div>
                <p class="text-sm text-gray-700 mb-5">Agrega productos a la factura antes de continuar.</p>
                <button onclick="document.getElementById('${id}').remove()"
                    class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition transform hover:scale-105">
                    Entendido
                </button>
            </div>
        `;
                document.body.appendChild(modal);
                return;
            }

            // Mostrar resumen si hay productos
            const resumen = carrito.map(p => `
        <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
            <span>${p.nombre}</span>
            <div class="flex items-center gap-4">
                <span class="text-gray-500">x ${p.cantidad}</span>
                <span class="font-medium">L. ${(p.precio * p.cantidad).toFixed(2)}</span>
            </div>
        </div>
    `).join('');

            document.getElementById('resumen-productos').innerHTML = resumen;
            document.getElementById('resumen-total').textContent = 'L. ' + document.getElementById('total-hidden').value;
            document.getElementById('modal-pago').classList.remove('hidden');
            document.getElementById('modal-pago').classList.add('flex');
            document.getElementById('monto-recibido').value = '';
            document.getElementById('monto-cambio').value = 'L. 0.00';
            document.getElementById('mensaje-error').classList.add('hidden');

            setTimeout(() => {
                document.getElementById('monto-recibido').focus();
            }, 300);
        }

        function cerrarModal() {
            document.getElementById('modal-pago').classList.add('hidden');
            document.getElementById('modal-pago').classList.remove('flex');
        }

        function actualizarCambio() {
            const total = parseFloat(document.getElementById('total-hidden').value);
            const recibido = parseFloat(document.getElementById('monto-recibido').value) || 0;
            const cambio = recibido - total;
            const cambioElement = document.getElementById('monto-cambio');
            const errorElement = document.getElementById('mensaje-error');

            if (cambio >= 0) {
                cambioElement.value = 'L. ' + cambio.toFixed(2);
                cambioElement.classList.remove('text-red-600');
                cambioElement.classList.add('text-green-600');
                errorElement.classList.add('hidden');
            } else {
                cambioElement.value = 'L. ' + Math.abs(cambio).toFixed(2);
                cambioElement.classList.remove('text-green-600');
                cambioElement.classList.add('text-red-600');
                errorElement.classList.remove('hidden');
            }
        }

        function confirmarPago() {
            const total = parseFloat(document.getElementById('total-hidden').value);
            const recibido = parseFloat(document.getElementById('monto-recibido').value) || 0;
            const error = document.getElementById('mensaje-error');

            if (recibido < total) {
                document.getElementById('monto-recibido').classList.add('ring-2', 'ring-red-500', 'animate-shake');
                setTimeout(() => {
                    document.getElementById('monto-recibido').classList.remove('ring-2', 'ring-red-500',
                        'animate-shake');
                }, 1000);
                return;
            }

            error.classList.add('hidden');
            document.getElementById('monto-recibido-hidden').value = recibido.toFixed(2);
            cerrarModal();
            localStorage.removeItem('carrito_tavocell');

            const loader = document.createElement('div');
            loader.className = 'fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50';
            loader.innerHTML = `
        <div class="bg-white p-6 rounded-xl shadow-xl flex flex-col items-center">
            <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
            <p class="text-gray-700">Procesando factura...</p>
        </div>`;
            document.body.appendChild(loader);

            setTimeout(() => {
                document.getElementById('factura-form').submit();
            }, 1000);
        }
    </script>

    <!-- Contenedor de Alertas Personalizadas -->
    <div id="toast-container" class="fixed top-4 right-4 space-y-4 z-[9999]"></div>

    <script>
        function mostrarAlerta(tipo = 'info', mensaje = 'Mensaje genérico', duracion = 3000) {
            const colores = {
                info: 'bg-blue-100 border-blue-500 text-blue-700',
                success: 'bg-green-100 border-green-500 text-green-700',
                warning: 'bg-yellow-100 border-yellow-500 text-yellow-700',
                error: 'bg-red-100 border-red-500 text-red-700',
            };

            const iconos = {
                info: 'ℹ️',
                success: '✅',
                warning: '⚠️',
                error: '❌',
            };

            const alerta = document.createElement('div');
            alerta.className =
                `toast ${colores[tipo]} border-l-4 p-4 rounded-lg shadow-lg animate-bounce-in transition-opacity`;
            alerta.innerHTML = `
            <div class="flex items-center gap-3">
                <span class="text-xl">${iconos[tipo]}</span>
                <span>${mensaje}</span>
            </div>
        `;

            const contenedor = document.getElementById('toast-container');
            contenedor.appendChild(alerta);

            setTimeout(() => {
                alerta.classList.add('opacity-0');
                setTimeout(() => alerta.remove(), 300);
            }, duracion);
        }
    </script>
@endsection

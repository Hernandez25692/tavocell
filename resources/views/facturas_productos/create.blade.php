@extends('layouts.app')

@section('content')
<div class="container max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold text-indigo-800 mb-6 flex items-center gap-2">
        🛒 Crear Factura de Productos
    </h1>

    @if (session('error'))
        <div class="bg-red-100 border border-red-500 text-red-700 p-4 mb-6 rounded">
            <strong>Error:</strong> {{ session('error') }}
        </div>
    @endif

    <form id="factura-form" method="POST" action="{{ route('facturas_productos.store') }}">
        @csrf
        <input type="hidden" name="metodo_pago" value="Efectivo">
        <input type="hidden" name="total" id="total-hidden">
        <input type="hidden" name="productos" id="productos-json">
        <input type="hidden" name="monto_recibido" id="monto-recibido-hidden">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- CLIENTE -->
            <div class="space-y-6">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="block text-sm font-medium mb-1 text-gray-700">Buscar Cliente por Identidad</label>
                    <input type="text" id="buscar-identidad" class="w-full rounded-md border-gray-300 shadow-sm"
                        placeholder="0801...">
                    <select name="cliente_id" id="cliente_id" class="mt-3 w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Seleccionar cliente --</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}" data-identidad="{{ $cliente->identidad }}">
                                {{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="block text-sm font-medium text-gray-700">Código de Barras</label>
                    <div class="flex gap-2">
                        <input type="text" id="codigo-producto" class="flex-grow rounded-md border-gray-300"
                            placeholder="Escanear o escribir código">
                        <button type="button" onclick="buscarProducto()"
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Buscar</button>
                    </div>

                    <label class="block text-sm font-medium mt-4 text-gray-700">Buscar por nombre</label>
                    <input type="text" id="nombre-producto" class="w-full rounded-md border-gray-300"
                        placeholder="Buscar producto...">
                    <div id="sugerencias-productos"
                        class="hidden mt-1 border border-gray-200 rounded bg-white shadow max-h-40 overflow-y-auto"></div>
                </div>
            </div>

            <!-- PRODUCTOS Y RESUMEN -->
            <div class="lg:col-span-2 space-y-4">
                <div class="overflow-x-auto border rounded-lg">
                    <table class="min-w-full text-sm divide-y divide-gray-200">
                        <thead class="bg-gray-100 text-gray-700 font-semibold">
                            <tr>
                                <th class="p-2">Código</th>
                                <th class="p-2">Nombre</th>
                                <th class="p-2">Precio</th>
                                <th class="p-2">Cantidad</th>
                                <th class="p-2">Subtotal</th>
                                <th class="p-2">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-productos" class="divide-y divide-gray-100 text-gray-800">
                        </tbody>
                    </table>
                </div>

                <div class="bg-gray-50 p-4 border rounded-lg">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Resumen</h3>
                        <p id="total-pagar" class="text-2xl font-bold text-green-600">L. 0.00</p>
                    </div>
                    <div class="mt-4 text-right">
                        <button type="button" onclick="limpiarCarrito()" class="mr-2 bg-gray-200 px-4 py-2 rounded">Limpiar</button>
                        <button type="button" onclick="mostrarResumen()" class="bg-indigo-600 text-white px-6 py-2 rounded">Facturar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- MODAL DE CONFIRMACIÓN -->
    <div id="modal-pago" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white p-6 rounded shadow max-w-lg w-full">
            <h2 class="text-xl font-bold text-indigo-700 mb-4">Resumen de Factura</h2>
            <div id="resumen-productos" class="text-sm mb-4 max-h-48 overflow-y-auto"></div>
            <p class="mb-2 font-bold">Total: <span id="resumen-total" class="text-green-600">L. 0.00</span></p>

            <label>Monto recibido:</label>
            <input type="number" id="monto-recibido" class="form-control w-full mb-2" oninput="actualizarCambio()">
            <label>Cambio:</label>
            <input type="text" id="monto-cambio" readonly class="form-control w-full bg-gray-100 mb-3 font-bold">

            <div id="mensaje-error" class="text-red-600 font-bold hidden mb-3">
                ⚠️ El monto recibido es menor al total.
            </div>

            <div class="flex justify-between">
                <button onclick="cerrarModal()" class="bg-gray-200 px-4 py-2 rounded">Cancelar</button>
                <button onclick="confirmarPago()" class="bg-indigo-600 text-white px-4 py-2 rounded">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
const productos = @json($productos);
const clientes = @json($clientes);
let carrito = [];

document.getElementById('buscar-identidad').addEventListener('input', function () {
    const identidad = this.value.trim();
    const select = document.getElementById('cliente_id');
    for (let option of select.options) {
        if (option.dataset.identidad === identidad) {
            select.value = option.value;
            break;
        }
    }
});

document.getElementById('nombre-producto').addEventListener('input', function () {
    const termino = this.value.toLowerCase();
    const contenedor = document.getElementById('sugerencias-productos');
    if (termino.length < 2) return contenedor.classList.add('hidden');

    const resultados = productos.filter(p => p.nombre.toLowerCase().includes(termino)).slice(0, 5);
    contenedor.innerHTML = resultados.map(p =>
        `<div class="px-4 py-2 cursor-pointer hover:bg-gray-100" onclick="seleccionarProducto('${p.codigo}')">${p.nombre} (${p.codigo})</div>`
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
    if (!producto) return alert('Producto no encontrado');

    const existente = carrito.find(p => p.id === producto.id);
    if (existente) {
        existente.cantidad += 1;
    } else {
        carrito.push({
            id: producto.id,
            codigo: producto.codigo,
            nombre: producto.nombre,
            precio: parseFloat(producto.precio_venta),
            cantidad: 1
        });
    }

    document.getElementById('codigo-producto').value = '';
    renderTabla();
}

function renderTabla() {
    const tbody = document.getElementById('tabla-productos');
    tbody.innerHTML = '';
    let total = 0;

    carrito.forEach((p, i) => {
        const subtotal = p.precio * p.cantidad;
        total += subtotal;

        tbody.innerHTML += `
        <tr>
            <td class="p-2">${p.codigo}</td>
            <td class="p-2">${p.nombre}</td>
            <td class="p-2">L. ${p.precio.toFixed(2)}</td>
            <td class="p-2"><input type="number" min="1" value="${p.cantidad}" class="w-16" onchange="actualizarCantidad(${i}, this.value)"></td>
            <td class="p-2">L. ${subtotal.toFixed(2)}</td>
            <td class="p-2"><button onclick="eliminarProducto(${i})" class="text-red-600">🗑️</button></td>
        </tr>`;
    });

    document.getElementById('total-pagar').textContent = 'L. ' + total.toFixed(2);
    document.getElementById('total-hidden').value = total.toFixed(2);
    document.getElementById('productos-json').value = JSON.stringify(carrito);
}

function actualizarCantidad(i, val) {
    carrito[i].cantidad = parseInt(val);
    renderTabla();
}

function eliminarProducto(i) {
    carrito.splice(i, 1);
    renderTabla();
}

function limpiarCarrito() {
    carrito = [];
    renderTabla();
}

function mostrarResumen() {
    if (!carrito.length) return alert('Agrega productos');
    const resumen = carrito.map(p => `<p>${p.nombre} x ${p.cantidad}</p>`).join('');
    document.getElementById('resumen-productos').innerHTML = resumen;
    document.getElementById('resumen-total').textContent = 'L. ' + document.getElementById('total-hidden').value;
    document.getElementById('modal-pago').classList.remove('hidden');
    document.getElementById('modal-pago').classList.add('flex');
}

function cerrarModal() {
    document.getElementById('modal-pago').classList.add('hidden');
    document.getElementById('modal-pago').classList.remove('flex');
}

function actualizarCambio() {
    const total = parseFloat(document.getElementById('total-hidden').value);
    const recibido = parseFloat(document.getElementById('monto-recibido').value);
    const cambio = recibido - total;
    document.getElementById('monto-cambio').value = 'L. ' + (cambio > 0 ? cambio.toFixed(2) : '0.00');
}

function confirmarPago() {
    const total = parseFloat(document.getElementById('total-hidden').value);
    const recibido = parseFloat(document.getElementById('monto-recibido').value);
    const error = document.getElementById('mensaje-error');

    if (recibido < total) {
        error.classList.remove('hidden');
        return;
    }

    error.classList.add('hidden');
    document.getElementById('monto-recibido-hidden').value = recibido.toFixed(2);
    cerrarModal();
    document.getElementById('factura-form').submit();
}
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container max-w-4xl mx-auto p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4 text-indigo-700">🧾 Nueva Factura (POS)</h1>

    @if (session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-3">
            {{ session('error') }}
        </div>
    @endif

    <form id="factura-form" method="POST" action="{{ route('facturas.store') }}">
        @csrf
        <input type="hidden" name="metodo_pago" value="Efectivo">
        <input type="hidden" name="total" id="total-hidden">
        <input type="hidden" name="productos" id="productos-json">

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Cliente (opcional):</label>
            <select name="cliente_id" class="form-control rounded border-gray-300 w-full">
                <option value="">-- Seleccionar cliente --</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Código del Producto:</label>
            <div class="flex gap-2">
                <input type="text" id="codigo-producto" class="form-control flex-grow" placeholder="Escanea o escribe el código" autofocus>
                <button type="button" class="btn btn-outline-secondary" onclick="buscarProducto()">Buscar</button>
                <button type="button" class="btn btn-info" onclick="abrirModalConsulta()">🔍 Consulta</button>
            </div>
        </div>

        <div class="overflow-x-auto mt-6">
            <table class="table-auto w-full border text-sm text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2">Código</th>
                        <th class="p-2">Producto</th>
                        <th class="p-2">Precio</th>
                        <th class="p-2">Cantidad</th>
                        <th class="p-2">Subtotal</th>
                        <th class="p-2">Acción</th>
                    </tr>
                </thead>
                <tbody id="tabla-productos" class="divide-y">
                    <!-- Productos JS -->
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-right">
            <label class="block font-semibold">Total a pagar:</label>
            <input type="text" id="total-pagar" class="form-control bg-gray-100 font-bold text-lg text-green-700" readonly value="L. 0.00">
        </div>

        <div class="mt-6 text-right">
            <button type="button" class="btn btn-success" onclick="mostrarResumen()">💰 Facturar</button>
        </div>
    </form>
</div>

{{-- Modal de resumen y confirmación --}}
<div id="modal-pago" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-lg mx-auto">
        <h2 class="text-xl font-bold mb-4 text-indigo-700">🧾 Resumen de Factura</h2>
        <div id="resumen-productos" class="mb-3 space-y-1 text-sm"></div>

        <div class="mb-3 font-bold">
            <p>Total a pagar: <span id="resumen-total" class="text-green-600">L. 0.00</span></p>
        </div>

        <div class="mb-3">
            <label>Monto recibido:</label>
            <input type="number" id="monto-recibido" class="form-control" step="0.01">
        </div>

        <div class="text-red-600 font-bold hidden mb-3" id="mensaje-error">
            ⚠️ El monto recibido es menor al total.
        </div>

        <div class="flex justify-between">
            <button class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
            <button class="btn btn-primary" onclick="confirmarPago()">Confirmar</button>
        </div>
    </div>
</div>

{{-- Modal de consulta (pendiente de implementar si deseas) --}}
{{-- Agrega aquí un modal de búsqueda avanzada si quieres más adelante --}}

<script>
    const productos = @json($productos);
    let carrito = [];

    document.getElementById('codigo-producto').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') buscarProducto();
    });

    function buscarProducto() {
        const codigo = document.getElementById('codigo-producto').value.trim();
        const producto = productos.find(p => p.codigo === codigo);

        if (!producto) {
            alert('❌ Producto no encontrado');
            return;
        }

        const existente = carrito.find(p => p.id === producto.id);
        if (existente) {
            existente.cantidad++;
        } else {
            carrito.push({ id: producto.id, codigo: producto.codigo, nombre: producto.nombre, precio: parseFloat(producto.precio_venta), cantidad: 1 });
        }

        document.getElementById('codigo-producto').value = '';
        renderTabla();
    }

    function eliminarProducto(index) {
        carrito.splice(index, 1);
        renderTabla();
    }

    function actualizarCantidad(index, valor) {
        const cantidad = parseInt(valor);
        if (cantidad > 0) {
            carrito[index].cantidad = cantidad;
            renderTabla();
        }
    }

    function renderTabla() {
        const tbody = document.getElementById('tabla-productos');
        tbody.innerHTML = '';
        let total = 0;

        carrito.forEach((p, index) => {
            const subtotal = p.precio * p.cantidad;
            total += subtotal;

            tbody.innerHTML += `
                <tr>
                    <td class="p-2">${p.codigo}</td>
                    <td class="p-2">${p.nombre}</td>
                    <td class="p-2">L. ${p.precio.toFixed(2)}</td>
                    <td class="p-2"><input type="number" min="1" class="form-control w-20" value="${p.cantidad}" onchange="actualizarCantidad(${index}, this.value)"></td>
                    <td class="p-2">L. ${subtotal.toFixed(2)}</td>
                    <td class="p-2"><button class="btn btn-danger btn-sm" onclick="eliminarProducto(${index})">🗑️</button></td>
                </tr>
            `;
        });

        document.getElementById('total-pagar').value = 'L. ' + total.toFixed(2);
        document.getElementById('total-hidden').value = total.toFixed(2);
        document.getElementById('productos-json').value = JSON.stringify(carrito);
    }

    function mostrarResumen() {
        if (carrito.length === 0) {
            alert('⚠️ Debes agregar al menos un producto');
            return;
        }

        let total = 0;
        let resumen = '';

        carrito.forEach(p => {
            resumen += `<p>${p.nombre} x ${p.cantidad}</p>`;
            total += p.precio * p.cantidad;
        });

        document.getElementById('resumen-productos').innerHTML = resumen;
        document.getElementById('resumen-total').innerText = 'L. ' + total.toFixed(2);
        document.getElementById('modal-pago').classList.remove('hidden');
        document.getElementById('modal-pago').classList.add('flex');
    }

    function cerrarModal() {
        document.getElementById('modal-pago').classList.add('hidden');
        document.getElementById('modal-pago').classList.remove('flex');
    }

    function confirmarPago() {
        const total = parseFloat(document.getElementById('total-hidden').value);
        const recibido = parseFloat(document.getElementById('monto-recibido').value) || 0;
        const mensaje = document.getElementById('mensaje-error');

        if (recibido < total) {
            mensaje.classList.remove('hidden');
            return;
        }

        mensaje.classList.add('hidden');
        cerrarModal();

        setTimeout(() => {
            alert(`✅ Factura generada. Cambio: L. ${(recibido - total).toFixed(2)}`);
            document.getElementById('factura-form').submit();
        }, 300);
    }
</script>
@endsection

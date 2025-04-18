@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">🧾 Nueva Venta</h1>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form id="venta-form" method="POST" action="{{ route('ventas.store') }}">
            @csrf
            <input type="hidden" name="metodo_pago" value="Efectivo">

            <div class="mb-3">
                <label>Cliente (opcional):</label>
                <select name="cliente_id" class="form-control">
                    <option value="">-- Seleccionar cliente --</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <h5 class="mt-4">Productos:</h5>
            <div id="productos-container"></div>

            <button type="button" class="btn btn-secondary mt-2" onclick="agregarProducto()">+ Producto</button>

            <div class="mt-4">
                <label>Total a pagar:</label>
                <input type="text" id="total-pagar" class="form-control bg-light" readonly value="L. 0.00">
            </div>

            <div class="mt-4">
                <button type="button" class="btn btn-success" onclick="mostrarResumen()">💰 Pagar</button>
            </div>
        </form>
    </div>

    {{-- Modal de resumen y pago --}}
    <div id="modal-pago" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white p-6 rounded shadow-xl w-full max-w-lg">
            <h4 class="text-lg font-bold mb-4">🧾 Resumen de Venta</h4>
            <div id="resumen-productos" class="mb-3"></div>

            <p><strong>Total a pagar:</strong> <span id="resumen-total">L. 0.00</span></p>

            <div class="mb-3 mt-3">
                <label>Monto recibido:</label>
                <input type="number" step="0.01" id="monto-recibido" class="form-control" required>
            </div>

            <div id="mensaje-error" class="text-danger font-bold mb-2 hidden">
                ⚠️ El monto recibido es menor al total.
            </div>

            <div class="text-right">
                <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="confirmarPago()">Confirmar</button>
            </div>
        </div>
    </div>

    <script>
        let productos = @json($productos);
        let index = 0;

        function agregarProducto() {
            const container = document.getElementById('productos-container');
            const div = document.createElement('div');
            div.classList.add('mb-3', 'producto-row');
            div.dataset.index = index;

            let opciones = productos.map(p =>
                `<option value="${p.id}" data-precio="${p.precio_venta}" data-stock="${p.stock}">
                ${p.nombre} (L. ${p.precio_venta}) - Stock: ${p.stock}
            </option>`
            ).join('');

            div.innerHTML = `
            <select name="productos[${index}][id]" class="form-control mb-1 producto-select" onchange="calcularTotal()">
                ${opciones}
            </select>
            <input type="number" name="productos[${index}][cantidad]" class="form-control cantidad-input" placeholder="Cantidad" min="1" value="1" onchange="calcularTotal()">
        `;

            container.appendChild(div);
            index++;
            calcularTotal();
        }

        function calcularTotal() {
            let total = 0;
            document.querySelectorAll('.producto-row').forEach(row => {
                const select = row.querySelector('.producto-select');
                const cantidad = parseFloat(row.querySelector('.cantidad-input').value) || 0;
                const precio = parseFloat(select.selectedOptions[0].dataset.precio) || 0;
                total += cantidad * precio;
            });
            document.getElementById('total-pagar').value = 'L. ' + total.toFixed(2);
            return total;
        }

        function mostrarResumen() {
            const resumen = document.getElementById('resumen-productos');
            const total = calcularTotal();
            const resumenTotal = document.getElementById('resumen-total');
            resumen.innerHTML = '';
            let stockOk = true;

            document.querySelectorAll('.producto-row').forEach(row => {
                const select = row.querySelector('.producto-select');
                const producto = select.selectedOptions[0].innerText;
                const cantidad = parseInt(row.querySelector('.cantidad-input').value);
                const stock = parseInt(select.selectedOptions[0].dataset.stock);

                if (cantidad > stock) {
                    alert(`❌ No puedes vender más del stock disponible para: ${producto}`);
                    stockOk = false;
                } else {
                    resumen.innerHTML += `<p>${producto} x ${cantidad}</p>`;
                }
            });

            if (!stockOk) return;

            resumenTotal.innerText = 'L. ' + total.toFixed(2);
            document.getElementById('modal-pago').classList.remove('hidden');
        }

        function cerrarModal() {
            document.getElementById('modal-pago').classList.add('hidden');
        }

        function confirmarPago() {
            const total = calcularTotal();
            const recibido = parseFloat(document.getElementById('monto-recibido').value) || 0;
            const mensaje = document.getElementById('mensaje-error');

            if (recibido < total) {
                mensaje.classList.remove('hidden');
                return;
            }

            mensaje.classList.add('hidden');
            cerrarModal();

            setTimeout(() => {
                alert('✅ Pago registrado. Cambio: L. ' + (recibido - total).toFixed(2));
                document.getElementById('venta-form').submit();
            }, 300);
        }
    </script>
@endsection

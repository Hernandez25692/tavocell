@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-2xl font-bold">📦 Ingreso de Inventario</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form id="form-ingreso" action="{{ route('inventario.store') }}" method="POST">
        @csrf

        <div id="productos-container" class="space-y-4"></div>

        <button type="button" class="btn btn-secondary mt-3" onclick="agregarProducto()">+ Agregar producto</button>

        <div class="mt-4">
            <button type="button" class="btn btn-success" onclick="mostrarResumen()">📊 Registrar Ingreso</button>
        </div>

        <!-- Modal de confirmación -->
        <div id="modal-confirm" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow-xl w-full max-w-lg">
                <h4 class="text-lg font-bold mb-4">📝 Resumen de ingreso</h4>
                <div id="resumen-contenido" class="mb-4"></div>
                <div class="text-right">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    let index = 0;
    let productos = @json($productos);

    function agregarProducto() {
        const container = document.getElementById('productos-container');
        const div = document.createElement('div');
        div.classList.add('producto-row');
        div.innerHTML = `
            <div class="flex gap-4 items-end">
                <div class="flex-1">
                    <label>Código:</label>
                    <input type="text" name="productos[${index}][codigo]" class="form-control" oninput="buscarNombre(this, ${index})" required>
                </div>
                <div class="flex-1">
                    <label>Nombre:</label>
                    <input type="text" id="nombre-${index}" class="form-control bg-gray-100" disabled>
                </div>
                <div class="flex-1">
                    <label>Cantidad:</label>
                    <input type="number" name="productos[${index}][cantidad]" class="form-control" min="1" required>
                </div>
            </div>
        `;
        container.appendChild(div);
        index++;
    }

    function buscarNombre(input, idx) {
        const codigo = input.value.trim();
        const producto = productos.find(p => p.codigo === codigo);
        const nombreInput = document.getElementById(`nombre-${idx}`);
        nombreInput.value = producto ? producto.nombre : 'No encontrado';
    }

    function mostrarResumen() {
        const resumen = document.getElementById('resumen-contenido');
        resumen.innerHTML = '';
        let filas = document.querySelectorAll('.producto-row');

        filas.forEach(row => {
            const codigo = row.querySelector('input[name*="[codigo]"]').value;
            const cantidad = row.querySelector('input[name*="[cantidad]"]').value;
            const nombre = row.querySelector('input[id^="nombre-"]').value;

            resumen.innerHTML += `<p><strong>${codigo}</strong> - ${nombre} → +${cantidad} unidades</p>`;
        });

        document.getElementById('modal-confirm').classList.remove('hidden');
        document.getElementById('modal-confirm').classList.add('flex');
    }

    function cerrarModal() {
        const modal = document.getElementById('modal-confirm');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection

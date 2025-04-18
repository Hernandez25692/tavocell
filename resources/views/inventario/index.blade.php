@extends('layouts.app')

@section('content')
<div class="inventory-container">
    <div class="inventory-header">
        <h1>Ingreso de Inventario</h1>
        <div class="header-actions">
            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>

    <form id="form-ingreso" action="{{ route('inventario.store') }}" method="POST" class="inventory-form">
        @csrf

        <div id="productos-container" class="products-container"></div>

        <div class="form-actions">
            <button type="button" class="add-product-btn" onclick="agregarProducto()">
                <span class="plus-icon">+</span> Agregar producto
            </button>
            
            <button type="button" class="submit-btn" onclick="mostrarResumen()">
                <span class="chart-icon">📊</span> Registrar Ingreso
            </button>
        </div>

        <!-- Modal de confirmación -->
        <div id="modal-confirm" class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Resumen de ingreso</h3>
                    <button class="modal-close" onclick="cerrarModal()">&times;</button>
                </div>
                <div id="resumen-contenido" class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="cancel-btn" onclick="cerrarModal()">Cancelar</button>
                    <button type="submit" class="confirm-btn">Confirmar</button>
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
        div.classList.add('product-row');
        div.innerHTML = `
            <div class="product-fields">
                <div class="field-group">
                    <label>Código</label>
                    <input type="text" name="productos[${index}][codigo]" 
                           class="form-input code-input" 
                           oninput="buscarNombre(this, ${index})" 
                           required
                           autocomplete="off">
                    <div class="code-suggestions" id="suggestions-${index}"></div>
                </div>
                
                <div class="field-group">
                    <label>Nombre</label>
                    <input type="text" id="nombre-${index}" 
                           class="form-input name-display" 
                           disabled>
                </div>
                
                <div class="field-group">
                    <label>Cantidad</label>
                    <input type="number" name="productos[${index}][cantidad]" 
                           class="form-input quantity-input" 
                           min="1" 
                           required>
                </div>
                
                <button type="button" class="remove-btn" onclick="this.parentElement.parentElement.remove()">
                    &times;
                </button>
            </div>
        `;
        container.appendChild(div);
        
        // Add event listener for the new code input
        const codeInput = div.querySelector('.code-input');
        codeInput.addEventListener('focus', function() {
            showSuggestions(this, index);
        });
        
        index++;
    }

    function buscarNombre(input, idx) {
        const codigo = input.value.trim();
        const producto = productos.find(p => p.codigo === codigo);
        const nombreInput = document.getElementById(`nombre-${idx}`);
        nombreInput.value = producto ? producto.nombre : 'No encontrado';
        
        showSuggestions(input, idx);
    }

    function showSuggestions(input, idx) {
        const searchTerm = input.value.toLowerCase();
        const suggestionsContainer = document.getElementById(`suggestions-${idx}`);
        
        if (searchTerm.length < 2) {
            suggestionsContainer.innerHTML = '';
            suggestionsContainer.style.display = 'none';
            return;
        }
        
        const matches = productos.filter(p => 
            p.codigo.toLowerCase().includes(searchTerm) || 
            p.nombre.toLowerCase().includes(searchTerm)
        ).slice(0, 5);
        
        if (matches.length === 0) {
            suggestionsContainer.innerHTML = '<div class="suggestion-item">No se encontraron coincidencias</div>';
        } else {
            suggestionsContainer.innerHTML = matches.map(p => `
                <div class="suggestion-item" onclick="selectSuggestion(this, ${idx}, '${p.codigo}')">
                    <span class="suggestion-code">${p.codigo}</span>
                    <span class="suggestion-name">${p.nombre}</span>
                </div>
            `).join('');
        }
        
        suggestionsContainer.style.display = 'block';
    }

    function selectSuggestion(element, idx, codigo) {
        const codeInput = document.querySelector(`input[name="productos[${idx}][codigo]"]`);
        codeInput.value = codigo;
        buscarNombre(codeInput, idx);
        document.getElementById(`suggestions-${idx}`).style.display = 'none';
    }

    function mostrarResumen() {
        const resumen = document.getElementById('resumen-contenido');
        resumen.innerHTML = '';
        let filas = document.querySelectorAll('.product-row');

        if (filas.length === 0) {
            resumen.innerHTML = '<p class="empty-summary">No hay productos agregados</p>';
        } else {
            filas.forEach(row => {
                const codigo = row.querySelector('input[name*="[codigo]"]').value;
                const cantidad = row.querySelector('input[name*="[cantidad]"]').value;
                const nombre = row.querySelector('input[id^="nombre-"]').value;

                resumen.innerHTML += `
                    <div class="summary-item">
                        <span class="item-code">${codigo}</span>
                        <span class="item-name">${nombre}</span>
                        <span class="item-quantity">+${cantidad} unidades</span>
                    </div>
                `;
            });
        }

        document.getElementById('modal-confirm').style.display = 'flex';
    }

    function cerrarModal() {
        document.getElementById('modal-confirm').style.display = 'none';
    }

    // Close suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.classList.contains('code-input')) {
            document.querySelectorAll('.code-suggestions').forEach(el => {
                el.style.display = 'none';
            });
        }
    });

    // Add first product automatically
    window.onload = function() {
        agregarProducto();
    };
</script>

<style>
    .inventory-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
        font-family: 'Segoe UI', Roboto, sans-serif;
    }

    .inventory-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .inventory-header h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a365d;
        margin: 0;
    }

    .success-message {
        background-color: #48bb78;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.9rem;
    }

    .inventory-form {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
    }

    .products-container {
        margin-bottom: 1.5rem;
    }

    .product-row {
        margin-bottom: 1rem;
        padding: 1rem;
        background-color: #f8fafc;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }

    .product-row:hover {
        background-color: #f1f5f9;
    }

    .product-fields {
        display: grid;
        grid-template-columns: 1fr 2fr 1fr auto;
        gap: 1rem;
        align-items: end;
        position: relative;
    }

    .field-group {
        display: flex;
        flex-direction: column;
    }

    .field-group label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #4a5568;
        margin-bottom: 0.5rem;
    }

    .form-input {
        padding: 0.5rem 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
    }

    .code-input {
        font-family: monospace;
    }

    .name-display {
        background-color: #edf2f7;
    }

    .quantity-input {
        text-align: right;
    }

    .remove-btn {
        background: none;
        border: none;
        font-size: 1.25rem;
        color: #e53e3e;
        cursor: pointer;
        padding: 0 0.5rem;
        margin-bottom: 0.5rem;
        transition: all 0.2s ease;
    }

    .remove-btn:hover {
        color: #c53030;
        transform: scale(1.2);
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 1.5rem;
    }

    .add-product-btn, .submit-btn {
        display: flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
    }

    .add-product-btn {
        background-color: #e2e8f0;
        color: #4a5568;
    }

    .add-product-btn:hover {
        background-color: #cbd5e0;
    }

    .submit-btn {
        background-color: #4299e1;
        color: white;
    }

    .submit-btn:hover {
        background-color: #3182ce;
    }

    .plus-icon, .chart-icon {
        margin-right: 0.5rem;
        font-size: 1rem;
    }

    /* Modal styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background-color: white;
        border-radius: 0.5rem;
        width: 100%;
        max-width: 500px;
        max-height: 80vh;
        overflow-y: auto;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .modal-header h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        color: #1a365d;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #718096;
        transition: color 0.2s ease;
    }

    .modal-close:hover {
        color: #4a5568;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        padding: 1rem 1.5rem;
        border-top: 1px solid #e2e8f0;
        gap: 0.75rem;
    }

    .cancel-btn, .confirm-btn {
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
    }

    .cancel-btn {
        background-color: #e2e8f0;
        color: #4a5568;
    }

    .cancel-btn:hover {
        background-color: #cbd5e0;
    }

    .confirm-btn {
        background-color: #48bb78;
        color: white;
    }

    .confirm-btn:hover {
        background-color: #38a169;
    }

    /* Summary items */
    .summary-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #edf2f7;
    }

    .summary-item:last-child {
        border-bottom: none;
    }

    .item-code {
        font-weight: 600;
        color: #2d3748;
        width: 100px;
    }

    .item-name {
        flex: 1;
        color: #4a5568;
    }

    .item-quantity {
        font-weight: 600;
        color: #38a169;
        width: 100px;
        text-align: right;
    }

    .empty-summary {
        color: #718096;
        text-align: center;
        padding: 1rem 0;
    }

    /* Code suggestions */
    .code-suggestions {
        position: absolute;
        background-color: white;
        border: 1px solid #e2e8f0;
        border-radius: 0.25rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: calc(100% - 1.5rem);
        z-index: 10;
        display: none;
        max-height: 200px;
        overflow-y: auto;
    }

    .suggestion-item {
        padding: 0.5rem 0.75rem;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .suggestion-item:hover {
        background-color: #f7fafc;
    }

    .suggestion-code {
        font-weight: 600;
        color: #2b6cb0;
        margin-right: 0.5rem;
        font-family: monospace;
    }

    .suggestion-name {
        color: #4a5568;
        font-size: 0.875rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .product-fields {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
        
        .form-actions {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .add-product-btn, .submit-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection
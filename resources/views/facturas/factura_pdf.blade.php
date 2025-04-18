<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $factura->id }} - TavoCell 504</title>
    <style>
        @page {
            margin: 0;
            size: A4;
        }
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 12px;
            margin: 1.5cm;
            color: #333;
            line-height: 1.4;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e74c3c;
        }
        .logo {
            height: 80px;
        }
        .invoice-info {
            text-align: right;
        }
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            color: #e74c3c;
            margin: 0;
        }
        .invoice-number {
            font-size: 16px;
            margin: 5px 0;
        }
        .company-info {
            margin-bottom: 25px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .company-details p {
            margin: 3px 0;
            color: #555;
        }
        .client-info, .invoice-details {
            width: 48%;
            float: left;
            margin-bottom: 20px;
        }
        .invoice-details {
            float: right;
            text-align: right;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 8px;
            padding-bottom: 3px;
            border-bottom: 1px solid #eee;
        }
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background-color: #f8f9fa;
            color: #2c3e50;
            font-weight: bold;
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }
        td {
            padding: 8px 10px;
            border: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .totals {
            width: 300px;
            float: right;
            margin-top: 10px;
        }
        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .totals-label {
            font-weight: bold;
        }
        .grand-total {
            font-size: 14px;
            font-weight: bold;
            color: #e74c3c;
        }
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 2px solid #e74c3c;
            text-align: center;
            font-size: 11px;
            color: #777;
        }
        .payment-method {
            margin-top: 5px;
            font-style: italic;
        }
        .terms {
            margin-top: 30px;
            font-size: 10px;
            color: #777;
            text-align: center;
        }
        .qr-code {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <div>
                <img src="{{ public_path('Logo/tavocell-logo.jpg') }}" alt="TavoCell 504" class="logo">
                <div class="company-info">
                    <div class="company-name">TavoCell 504</div>
                    <div class="company-details">
                        <p>Teléfono: (+504)3238-4184</p>
                        <p>Email: info@tavocell.com</p>
                        <p>Dirección:Namasigue, 02009 San Jeronimo, Choluteca</p>
                        <p>RTN: 0801-9999-99999</p>
                    </div>
                </div>
            </div>
            <div class="invoice-info">
                <h1 class="invoice-title">FACTURA</h1>
                <div class="invoice-number">No. {{ $factura->id }}</div>
                <div class="invoice-date">Fecha: {{ $factura->created_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>

        <div class="clearfix">
            <div class="client-info">
                <div class="section-title">DATOS DEL CLIENTE</div>
                <p><strong>Nombre:</strong> {{ $factura->cliente->nombre ?? 'Consumidor Final' }}</p>
                <p><strong>RTN:</strong> {{ $factura->cliente->rtn ?? 'N/A' }}</p>
            </div>

            <div class="invoice-details">
                <div class="section-title">DETALLES DE FACTURA</div>
                <p><strong>Vendedor:</strong> {{ $factura->usuario->name ?? 'No registrado' }}</p>
                <p><strong>Caja:</strong> {{ $factura->caja_id ?? '1' }}</p>
                <p><strong>Método de pago:</strong> {{ $factura->metodo_pago }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="45%">Descripción</th>
                    <th width="10%">Cantidad</th>
                    <th width="15%">Precio Unitario</th>
                    <th width="15%">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($factura->detalles as $index => $detalle)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>L. {{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td>L. {{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="clearfix">
            <div class="totals">
                <div class="totals-row">
                    <span class="totals-label">Subtotal:</span>
                    <span>L. {{ number_format($factura->subtotal, 2) }}</span>
                </div>
                <div class="totals-row">
                    <span class="totals-label">ISV (15%):</span>
                    <span>L. {{ number_format($factura->total - $factura->subtotal, 2) }}</span>
                </div>
                <div class="totals-row grand-total">
                    <span class="totals-label">TOTAL:</span>
                    <span>L. {{ number_format($factura->total, 2) }}</span>
                </div>
                @if($factura->metodo_pago === 'Efectivo')
                <div class="totals-row">
                    <span class="totals-label">Efectivo:</span>
                    <span>L. {{ number_format($factura->monto_recibido, 2) }}</span>
                </div>
                <div class="totals-row">
                    <span class="totals-label">Cambio:</span>
                    <span>L. {{ number_format($factura->monto_recibido - $factura->total, 2) }}</span>
                </div>
                @endif
            </div>
        </div>


        <div class="qr-code">
            <!-- Space for QR code if implemented -->
            <p>Factura electrónica generada por TavoCell 504</p>
        </div>

        <div class="terms">
            <p>Esta factura es un documento legal. Favor verificar que todos los datos sean correctos.</p>
            <p>No se aceptan devoluciones después de 7 días de la compra.</p>
            <p>Original: Cliente - Copia: TavoCell 504</p>
        </div>

        <div class="footer">
            <p>"HONRADEZ, CALIDAD Y SERVICIO"</p>
            <p>¡Gracias {{ $factura->cliente->nombre ?? ' ' }} por su preferencia!</p>
        </div>
    </div>
</body>
</html>
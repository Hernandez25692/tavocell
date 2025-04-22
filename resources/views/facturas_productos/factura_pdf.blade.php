<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ $esCopia ? 'Copia - ' : '' }}Factura #{{ $factura->id }}</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            margin: 1.5cm;
            color: #333;
            background-color: #fff;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 15px;
        }

        .logo-container {
            width: 150px;
        }

        .logo {
            max-width: 100%;
            height: auto;
        }

        .header-info {
            text-align: right;
        }

        h1 {
            text-align: center;
            font-size: 18px;
            margin: 10px 0;
            color: #1e40af;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .copia {
            text-align: center;
            color: #b91c1c;
            font-weight: bold;
            margin-bottom: 15px;
            padding: 5px;
            background-color: #fee2e2;
            border-radius: 4px;
        }

        .datos {
            margin-bottom: 25px;
            background-color: #f8fafc;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        .datos table {
            width: 100%;
        }

        .datos td {
            padding: 6px 10px;
            vertical-align: top;
        }

        .datos strong {
            color: #1e40af;
        }

        .productos {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .productos th {
            background-color: #3b82f6;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: 500;
        }

        .productos td {
            border: 1px solid #e2e8f0;
            padding: 8px 10px;
        }

        .productos tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .totales {
            width: 50%;
            margin-left: auto;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .totales td {
            padding: 8px 15px;
            border: 1px solid #e2e8f0;
        }

        .totales tr:last-child td {
            font-weight: bold;
            background-color: #f0f9ff;
            color: #0369a1;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }

        .footer strong {
            color: #1e40af;
        }

        .qr-code {
            margin-top: 20px;
            text-align: center;
        }

        .legal-text {
            font-size: 10px;
            margin-top: 10px;
            line-height: 1.4;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo-container">
            <img src="{{ public_path('Logo/logo_menu.png') }}" class="logo" alt="TavoCell 504 Logo">
        </div>
        <div class="header-info">
            <div style="font-size: 14px; font-weight: bold; color: #1e40af;">TAVOCELL 504</div>
            <div>Teléfono: +504 3238-4184</div>
            <div>Email: info@tavocell504.com</div>
            <div>Dirección: San Jeronimo, Namasigue, Honduras</div>
            <div>RTN: 00000000000000</div>
        </div>
    </div>

    @if ($esCopia)
        <div class="copia">COPIA DE FACTURA - NO VÁLIDA PARA CRÉDITO FISCAL</div>
    @else
        <div class="copia">FACTURA ORIGINAL</div>
    @endif

    <h1>FACTURA #{{ $factura->id }}</h1>

    <div class="datos">
        <table>
            <tr>
                <td width="50%">
                    <strong>Cliente:</strong> {{ $factura->cliente->nombre ?? 'Consumidor Final' }}<br>

                </td>
                <td width="50%">
                    <strong>Fecha:</strong> {{ $factura->created_at->format('d/m/Y H:i') }}<br>
                    <strong>Cajero:</strong> {{ $factura->usuario->name }}<br>
                    <strong>Método de Pago:</strong> {{ ucfirst($factura->metodo_pago ?? 'Efectivo') }}
                </td>
            </tr>
        </table>
    </div>

    <table class="productos">
        <thead>
            <tr>
                <th width="55%">Descripción</th>
                <th width="15%">Cantidad</th>
                <th width="15%">P. Unitario</th>
                <th width="15%">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($factura->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre ?? 'Servicio de reparación' }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>L. {{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td>L. {{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totales">
        <tr>
            <td><strong>Total:</strong></td>
            <td>L. {{ number_format($factura->total, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Recibido:</strong></td>
            <td>L. {{ number_format($factura->monto_recibido, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Cambio:</strong></td>
            <td>L. {{ number_format($factura->cambio, 2) }}</td>
        </tr>
    </table>

    <div class="qr-code">
        <!-- Espacio para código QR si se desea implementar -->
        <!-- <img src="path_to_qr.png" width="100"> -->
    </div>

    <div class="footer">
        <p>Gracias por su compra en <strong>TavoCell 504</strong></p>
        <p>¡Su satisfacción es nuestra prioridad!</p>
        <div class="legal-text">
            Esta factura es un documento legal. No válida sin sello y firma autorizada.<br>
            Original: Cliente | Copia: Establecimiento
        </div>
    </div>
</body>

</html>

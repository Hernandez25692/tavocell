<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $esCopia ? 'Copia - ' : '' }}Factura #{{ $factura->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 40px;
            color: #333;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .datos,
        .resumen {
            margin-bottom: 20px;
        }

        .datos td {
            padding: 4px 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .productos th,
        .productos td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .productos th {
            background-color: #f4f4f4;
        }

        .totales td {
            padding: 6px 8px;
            text-align: right;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }

        .copia {
            text-align: center;
            color: #b91c1c;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $esCopia ? 'Copia - ' : '' }}Factura #{{ $factura->id }}</h1>
    </div>

    <div class="datos">
        <table>
            <tr>
                <td><strong>Cliente:</strong> {{ $factura->cliente->nombre ?? 'Consumidor Final' }}</td>
                <td><strong>Fecha:</strong> {{ $factura->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td><strong>Cajero:</strong> {{ $factura->usuario->name }}</td>
                <td><strong>Método de Pago:</strong> {{ ucfirst($factura->metodo_pago ?? 'Efectivo') }}</td>
            </tr>
        </table>
    </div>

    <table class="productos">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario (L.)</th>
                <th>Subtotal (L.)</th>
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

    <table class="totales" style="margin-top: 20px;">
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

    <div class="footer">
        @if ($esCopia)
            <div class="copia">Este documento es una <u>COPIA</u> de la factura original.</div>
        @else
            <div class="copia">Factura original emitida al cliente.</div>
        @endif
        <p>Gracias por su compra en <strong>TavoCell 504</strong></p>
    </div>
</body>
</html>

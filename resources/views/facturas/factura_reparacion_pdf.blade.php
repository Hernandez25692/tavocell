<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura Reparación #{{ $factura->id }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 13px;
            margin: 40px;
            color: #333;
        }
        h1 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .header, .footer {
            text-align: center;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .table th, .table td {
            padding: 8px;
            border: 1px solid #999;
        }
        .table th {
            background: #f0f0f0;
        }
        .info {
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .total {
            font-weight: bold;
        }
        .right {
            text-align: right;
        }
        .signature {
            margin-top: 40px;
            text-align: center;
        }
        .signature div {
            border-top: 1px solid #000;
            width: 200px;
            margin: 0 auto;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Factura de Reparación #{{ $factura->id }}</h1>
        <p><strong>Fecha:</strong> {{ $factura->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="info">
        <p><strong>Cliente:</strong> {{ $factura->cliente->nombre ?? 'Consumidor Final' }}</p>
        <p><strong>Teléfono:</strong> {{ $factura->cliente->telefono ?? '-' }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Dispositivo</th>
                <th>Falla Reportada</th>
                <th>Accesorios</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $reparacion->marca }} {{ $reparacion->modelo }}</td>
                <td>{{ $reparacion->falla_reportada }}</td>
                <td>{{ $reparacion->accesorios ?? 'Ninguno' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table" style="margin-top: 30px">
        <tr>
            <td class="right">Costo Total:</td>
            <td class="right">L. {{ number_format($reparacion->costo_total, 2) }}</td>
        </tr>
        <tr>
            <td class="right">Abono Inicial:</td>
            <td class="right">L. {{ number_format($reparacion->abono, 2) }}</td>
        </tr>
        <tr class="total">
            <td class="right">Saldo Pendiente:</td>
            <td class="right">L. {{ number_format($reparacion->costo_total - $reparacion->abono, 2) }}</td>
        </tr>
    </table>

    <div class="signature">
        <p>Firma del Cliente</p>
        <div></div>
    </div>

    <div class="footer">
        <p>Gracias por confiar en TavoCell 504</p>
    </div>
</body>
</html>

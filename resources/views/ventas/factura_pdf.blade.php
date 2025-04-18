<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $venta->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .encabezado { text-align: center; margin-bottom: 20px; }
        .tabla { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .tabla th, .tabla td { border: 1px solid #000; padding: 5px; text-align: left; }
        .totales { margin-top: 20px; text-align: right; }
    </style>
</head>
<body>
    <div class="encabezado">
        <h2>TavoCell 504</h2>
        <p>Factura de Venta #{{ $venta->id }}</p>
        <p>Fecha: {{ $venta->fecha_venta }}</p>
    </div>

    <p><strong>Cliente:</strong> {{ $venta->cliente->nombre ?? 'Consumidor Final' }}</p>
    <p><strong>Vendedor:</strong> {{ $venta->vendedor->name }}</p>
    <p><strong>Método de pago:</strong> {{ $venta->metodo_pago }}</p>

    <table class="tabla">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($venta->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>L. {{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td>L. {{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totales">
        <p><strong>Total: L. {{ number_format($venta->total, 2) }}</strong></p>
    </div>
</body>
</html>

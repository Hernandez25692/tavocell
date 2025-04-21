<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reparación Lista</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>📱 ¡Hola {{ $reparacion->cliente->nombre }}!</h2>
    <p>Queremos informarte que tu equipo <strong>{{ $reparacion->marca }} {{ $reparacion->modelo }}</strong> ya ha sido reparado y está <strong>listo para ser entregado</strong>.</p>

    <p><strong>Detalles:</strong></p>
    <ul>
        <li><strong>Falla reportada:</strong> {{ $reparacion->falla_reportada }}</li>
        <li><strong>Costo total:</strong> L. {{ number_format($reparacion->costo_total, 2) }}</li>
        <li><strong>Abono actual:</strong> L. {{ number_format($reparacion->abono, 2) }}</li>
    </ul>

    <p>Podés pasar por la tienda para retirarlo. Si aún queda saldo pendiente, podrás cancelarlo al momento de la entrega.</p>

    <p>Gracias por confiar en <strong>TavoCell 504</strong> 🔧</p>
</body>
</html>

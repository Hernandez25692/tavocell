<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seguimiento de Reparación</title>
    <style>
        body { font-family: sans-serif; background: #f9f9f9; padding: 30px; color: #333; }
        .container { max-width: 800px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        h1 { color: #1e40af; font-size: 24px; margin-bottom: 20px; }
        .info { margin-bottom: 25px; }
        .info p { margin: 6px 0; }
        .timeline { border-left: 3px solid #1e40af; padding-left: 20px; }
        .timeline-item { margin-bottom: 20px; }
        .timeline-item h4 { margin: 0; font-size: 16px; color: #1e40af; }
        .timeline-item p { margin: 2px 0; }
    </style>
</head>
<body>
<div class="container">
    <h1>📋 Historial de Reparación #{{ $reparacion->id }}</h1>

    <div class="info">
        <p><strong>Cliente:</strong> {{ $reparacion->cliente->nombre }}</p>
        <p><strong>Dispositivo:</strong> {{ $reparacion->marca }} {{ $reparacion->modelo }}</p>
        <p><strong>Falla reportada:</strong> {{ $reparacion->falla_reportada }}</p>
        <p><strong>Estado actual:</strong> <strong style="color: green">{{ ucfirst($reparacion->estado) }}</strong></p>
    </div>

    <h2 style="font-size:18px; color:#1e40af;">📌 Seguimiento:</h2>
    <div class="timeline">
        @forelse($reparacion->seguimientos as $item)
            <div class="timeline-item">
                <h4>{{ $item->created_at->format('d M Y H:i') }}</h4>
                <p><strong>Estado:</strong> {{ ucfirst($item->estado) }}</p>
                <p><strong>Comentario:</strong> {{ $item->comentario }}</p>
            </div>
        @empty
            <p>⏳ Aún no hay seguimiento registrado para esta reparación.</p>
        @endforelse
    </div>
</div>
</body>
</html>

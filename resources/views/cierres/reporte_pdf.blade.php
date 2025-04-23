<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Z - Cierre Diario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            margin: 20px;
        }
        h2 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 10px;
        }
        .resumen {
            margin-top: 20px;
            border: 1px dashed #999;
            padding: 10px;
        }
        .resumen p {
            margin: 4px 0;
        }
        .total-final {
            font-size: 16px;
            font-weight: bold;
            margin-top: 12px;
        }
        .cuadro {
            font-weight: bold;
            color: green;
        }
        .faltante {
            font-weight: bold;
            color: red;
        }
        .sobrante {
            font-weight: bold;
            color: blue;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <h2>Reporte Z - Cierre Diario</h2>
    
    <p><strong>Fecha del Cierre:</strong> {{ $fecha }}</p>
    <p><strong>Responsable:</strong> {{ $usuario }}</p>

    <div class="resumen">
        <p><strong>Total Ventas de Productos:</strong> L. {{ number_format($ventas, 2) }}</p>
        <p><strong>Total Reparaciones Facturadas:</strong> L. {{ number_format($reparaciones, 2) }}</p>
        <p><strong>Total Abonos Registrados:</strong> L. {{ number_format($abonos, 2) }}</p>
        <p class="total-final"><strong>Total Registrado en Sistema:</strong> L. {{ number_format($totalFinal, 2) }}</p>

        @if (!is_null($efectivo_fisico))
            <p><strong>Efectivo Físico Contado:</strong> L. {{ number_format($efectivo_fisico, 2) }}</p>
            <p><strong>Diferencia:</strong> 
                L. {{ number_format($diferencia, 2) }} -
                @if ($diferencia === 0)
                    <span class="cuadro">Cuadrado correctamente</span>
                @elseif ($diferencia > 0)
                    <span class="sobrante">Sobrante registrado</span>
                @else
                    <span class="faltante">Faltante detectado</span>
                @endif
            </p>
        @else
            <p><em>Nota: Aún no se ha ingresado el efectivo físico contado.</em></p>
        @endif
    </div>

    <div class="footer">
        Sistema TavoCell504 &copy; {{ date('Y') }} - Reporte generado automáticamente
    </div>
</body>
</html>

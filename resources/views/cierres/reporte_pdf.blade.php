<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Z - Cierre Diario</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 1.5cm;
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
        h2 {
            text-align: center;
            font-size: 18px;
            margin: 10px 0;
            color: #1e40af;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        .info-cierre {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8fafc;
            border-radius: 6px;
        }
        .resumen {
            margin-top: 20px;
            border: 1px solid #e2e8f0;
            padding: 15px;
            border-radius: 8px;
            background-color: #f8fafc;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .resumen p {
            margin: 8px 0;
            padding: 6px 10px;
            border-bottom: 1px dashed #e2e8f0;
            display: flex;
            justify-content: space-between;
        }
        .resumen p:last-child {
            border-bottom: none;
        }
        .total-final {
            font-size: 16px;
            font-weight: bold;
            margin-top: 15px;
            padding: 10px;
            background-color: #e0f2fe;
            border-radius: 6px;
            color: #0369a1;
            display: flex;
            justify-content: space-between;
        }
        .cuadro {
            font-weight: bold;
            color: #16a34a;
            background-color: #dcfce7;
            padding: 2px 8px;
            border-radius: 4px;
        }
        .faltante {
            font-weight: bold;
            color: #dc2626;
            background-color: #fee2e2;
            padding: 2px 8px;
            border-radius: 4px;
        }
        .sobrante {
            font-weight: bold;
            color: #2563eb;
            background-color: #dbeafe;
            padding: 2px 8px;
            border-radius: 4px;
        }
        .diferencia-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .diferencia-text {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }
        .nota {
            font-style: italic;
            color: #64748b;
            margin-top: 10px;
            padding: 8px;
            background-color: #f8fafc;
            border-radius: 4px;
        }
        .valor {
            font-weight: 600;
            color: #1e40af;
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
            <div>Reporte Z - Cierre Diario</div>
            <div>Fecha de generación: {{ now()->format('d/m/Y H:i') }}</div>
        </div>
    </div>

    <h2>DETALLE DE CIERRE</h2>
    
    <div class="info-cierre">
        <div>
            <strong>Fecha del Cierre:</strong> <span class="valor">{{ $fecha }}</span>
        </div>
        <div>
            <strong>Responsable:</strong> <span class="valor">{{ $usuario }}</span>
        </div>
    </div>

    <div class="resumen">
        <p>
            <span><strong>Total Ventas de Productos:</strong></span>
            <span class="valor">L. {{ number_format($ventas, 2) }}</span>
        </p>
        <p>
            <span><strong>Total Reparaciones Facturadas:</strong></span>
            <span class="valor">L. {{ number_format($reparaciones, 2) }}</span>
        </p>
        <p>
            <span><strong>Total Abonos Registrados:</strong></span>
            <span class="valor">L. {{ number_format($abonos, 2) }}</span>
        </p>
        <div class="total-final">
            <span><strong>TOTAL REGISTRADO EN SISTEMA:</strong></span>
            <span>L. {{ number_format($totalFinal, 2) }}</span>
        </div>

        @if (!is_null($efectivo_fisico))
            <p>
                <span><strong>Efectivo Físico Contado:</strong></span>
                <span class="valor">L. {{ number_format($efectivo_fisico, 2) }}</span>
            </p>
            <p>
                <div class="diferencia-container">
                    <span><strong>Diferencia:</strong></span>
                    <div class="diferencia-text">
                        <span class="valor">L. {{ number_format(abs($diferencia), 2) }}</span>
                        @if ($diferencia ===  0.00)
                            <span class="cuadro">CUADRADO CORRECTAMENTE</span>
                        @elseif ($diferencia > 0)
                            <span class="sobrante">SOBRANTE</span>
                        @else
                            <span class="faltante">FALTANTE</span>
                        @endif
                    </div>
                </div>
            </p>
        @else
            <div class="nota">
                Nota: Aún no se ha ingresado el efectivo físico contado.
            </div>
        @endif
    </div>

    <div class="footer">
        Sistema TavoCell504 &copy; {{ date('Y') }} - Reporte generado automáticamente
    </div>
</body>
</html>
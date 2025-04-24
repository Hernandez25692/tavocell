<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Comprobante de Reparación - TavoCell 504</title>
    <style>
        @page {
            size: letter portrait;
            margin: 1cm;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #fff;
        }

        .container {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            padding: 10px;
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px solid #1e40af;
        }

        .logo {
            height: 60px;
            margin-bottom: 5px;
        }

        .company-info {
            font-size: 9px;
            color: #6b7280;
        }

        h1 {
            font-size: 16px;
            margin: 5px 0;
            color: #1e40af;
        }

        .subtitle {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .highlight {
            background-color: #f3f4f6;
            padding: 8px;
            margin: 8px 0;
            border-left: 4px solid #1e40af;
        }

        .highlight-title {
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .info-table td {
            padding: 4px 6px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        .info-table .label {
            font-weight: bold;
            width: 35%;
            background-color: #f9fafb;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
        }

        .qr-section {
            text-align: center;
            width: 130px;
        }

        .qr {
            width: 80px;
            height: 80px;
            margin: 0 auto;
        }

        .qr-text {
            font-size: 9px;
            margin-top: 4px;
            color: #6b7280;
        }

        .signature {
            text-align: center;
            width: 60%;
        }

        .signature-line {
            margin-top: 20px;
            border-top: 1px solid #000;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }

        .signature-text {
            font-size: 11px;
            margin-top: 5px;
        }

        .terms {
            font-size: 8px;
            color: #6b7280;
            margin-top: 10px;
            text-align: justify;
            line-height: 1.3;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-pendiente {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-proceso {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-completado {
            background-color: #d1fae5;
            color: #065f46;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('Logo/logo_menu.png') }}" class="logo" alt="TavoCell 504 Logo">
            <div class="company-info">TavoCell 504 - Especialistas en Reparación de Dispositivos Móviles</div>
            <h1>COMPROBANTE DE REPARACIÓN</h1>
            <div class="subtitle">Seguimiento de estado de su dispositivo</div>
        </div>

        <div class="highlight">
            <div class="highlight-title">INFORMACIÓN DEL CLIENTE</div>
            <table class="info-table">
                <tr><td class="label">Código de Reparación:</td><td>#{{ $reparacion->id }}</td></tr>
                <tr><td class="label">Cliente:</td><td>{{ $reparacion->cliente->nombre }}</td></tr>
                <tr><td class="label">Teléfono:</td><td>{{ $reparacion->cliente->telefono ?? 'No especificado' }}</td></tr>
                <tr><td class="label">Correo:</td><td>{{ $reparacion->cliente->correo ?? 'No especificado' }}</td></tr>
            </table>
        </div>

        <div class="highlight">
            <div class="highlight-title">INFORMACIÓN DEL DISPOSITIVO</div>
            <table class="info-table">
                <tr><td class="label">Marca / Modelo:</td><td>{{ $reparacion->marca }} / {{ $reparacion->modelo }}</td></tr>
                <tr><td class="label">IMEI/Serial:</td><td>{{ $reparacion->imei ?? 'No registrado' }}</td></tr>
                <tr><td class="label">Falla Reportada:</td><td>{{ $reparacion->falla_reportada }}</td></tr>
                <tr><td class="label">Accesorios:</td><td>{{ $reparacion->accesorios ?? 'No especificado' }}</td></tr>
            </table>
        </div>

        <div class="highlight">
            <div class="highlight-title">DETALLES FINANCIEROS</div>
            <table class="info-table">
                <tr><td class="label">Fecha de Ingreso:</td><td>{{ $reparacion->fecha_ingreso }}</td></tr>
                <tr><td class="label">Fecha Estimada Entrega:</td><td>{{ $reparacion->fecha_entrega_estimada ?? 'Por confirmar' }}</td></tr>
                <tr><td class="label">Costo Estimado:</td><td>L. {{ number_format($reparacion->costo_total, 2) }}</td></tr>
                <tr><td class="label">Abono:</td><td>L. {{ number_format($reparacion->abono, 2) }}</td></tr>
                <tr><td class="label">Saldo Pendiente:</td><td>L. {{ number_format($reparacion->costo_total - $reparacion->abono, 2) }}</td></tr>
            </table>
        </div>

        <div class="footer">
            <div class="signature">
                <div class="signature-text">Firma del Cliente</div>
                <div class="signature-line"></div>
            </div>
            <br>
            <br>
            <div class="qr-section">
                <img src="{{ $qrPath }}" class="qr" alt="Código QR">
                <div class="qr-text">Escanee para dar seguimiento</div>
            </div>
        </div>

        <div class="terms">
            <p><strong>TÉRMINOS Y CONDICIONES:</strong> TavoCell 504 no se hace responsable por daños o pérdida de datos durante el proceso de reparación. Se recomienda realizar copia de seguridad antes de entregar el dispositivo. El cliente tiene 30 días para reclamar después de la fecha de entrega. Pasado este tiempo, el dispositivo no reclamado será considerado abandonado según nuestra política. Garantía de 30 días en repuestos y mano de obra, excepto en casos de daño físico o mal uso.</p>
            <p style="text-align: center; margin-top: 6px;">¡Gracias por confiar en <strong>TavoCell 504</strong>!</p>
        </div>
    </div>
</body>

</html>

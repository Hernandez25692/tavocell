<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Comprobante de Reparación</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 30px;
            color: #333;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
            color: #1e40af;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 8px 5px;
        }

        .info-table td.label {
            font-weight: bold;
            width: 30%;
            color: #111827;
        }

        .qr {
            margin-top: 25px;
            text-align: right;
        }

        .qr img {
            width: 100px;
        }

        .firma {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
        }

        .firma .linea {
            margin-top: 40px;
            border-top: 1px solid #000;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>

    <h1>📄 Comprobante de Recibido - Reparación</h1>

    <table class="info-table">
        <tr>
            <td class="label">Código de Reparación:</td>
            <td>#{{ $reparacion->id }}</td>
        </tr>
        <tr>
            <td class="label">Cliente:</td>
            <td>{{ $reparacion->cliente->nombre }}</td>
        </tr>
        <tr>
            <td class="label">Fecha de Ingreso:</td>
            <td>{{ $reparacion->fecha_ingreso }}</td>
        </tr>
        <tr>
            <td class="label">Marca / Modelo:</td>
            <td>{{ $reparacion->marca }} / {{ $reparacion->modelo }}</td>
        </tr>
        <tr>
            <td class="label">IMEI:</td>
            <td>{{ $reparacion->imei ?? 'No registrado' }}</td>
        </tr>
        <tr>
            <td class="label">Falla Reportada:</td>
            <td>{{ $reparacion->falla_reportada }}</td>
        </tr>
        <tr>
            <td class="label">Accesorios:</td>
            <td>{{ $reparacion->accesorios ?? 'No especificado' }}</td>
        </tr>
        <tr>
            <td class="label">Costo Estimado:</td>
            <td>L. {{ number_format($reparacion->costo_total, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Abono:</td>
            <td>L. {{ number_format($reparacion->abono, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Saldo Pendiente:</td>
            <td>L. {{ number_format($reparacion->costo_total - $reparacion->abono, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Estado:</td>
            <td>{{ strtoupper($reparacion->estado) }}</td>
        </tr>
    </table>

    <div class="qr">
        <img src="{{ $qrPath }}" alt="Código QR">
        <div style="font-size: 10px; margin-top: 5px;">
            Escanee para dar seguimiento
        </div>
    </div>



    <div class="firma">
        <p>Firma del Cliente</p>
        <div class="linea"></div>
    </div>

</body>

</html>

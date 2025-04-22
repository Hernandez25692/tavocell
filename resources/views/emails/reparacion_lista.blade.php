<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tu reparación está lista - TavoCell 504</title>
    <style>
        /* Estilos base */
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9fafb;
        }
        
        /* Contenedor principal */
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }
        
        /* Encabezado */
        .header {
            background-color: #2563eb;
            padding: 20px;
            text-align: center;
        }
        
        .logo {
            height: 80px;
            width: auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Contenido */
        .content {
            padding: 25px;
        }
        
        h1 {
            color: #2563eb;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        h2 {
            color: #1e40af;
            font-size: 20px;
            margin-top: 25px;
            margin-bottom: 15px;
        }
        
        p {
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        ul {
            margin-bottom: 20px;
            padding-left: 20px;
        }
        
        li {
            margin-bottom: 8px;
        }
        
        strong {
            color: #1e293b;
        }
        
        /* Tarjeta de información */
        .info-card {
            background-color: #f8fafc;
            border-left: 4px solid #2563eb;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        
        /* Pie de página */
        .footer {
            background-color: #f1f5f9;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
        
        .highlight {
            background-color: #dbeafe;
            padding: 2px 5px;
            border-radius: 4px;
            font-weight: bold;
        }
        
        /* Botón */
        .btn {
            display: inline-block;
            background-color: #2563eb;
            color: white !important;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: bold;
            margin: 15px 0;
            text-align: center;
        }
        
        /* Responsivo */
        @media only screen and (max-width: 600px) {
            .content {
                padding: 15px;
            }
            
            .logo {
                height: 60px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Encabezado con logo -->
        <div class="flex items-center">
                        <div>
                            <h1 class="text-2xl font-bold">Seguimiento de Reparación #{{ $reparacion->id }}</h1>
                        </div>
                    </div>
        
        <!-- Contenido principal -->
        <div class="content">
            <h1>📱 ¡Tu reparación está lista!</h1>
            
            <p>Hola <strong>{{ $reparacion->cliente->nombre }}</strong>,</p>
            
            <p>Nos complace informarte que tu dispositivo <strong>{{ $reparacion->marca }} {{ $reparacion->modelo }}</strong> ha sido reparado exitosamente y está listo para ser retirado en nuestro local.</p>
            
            <div class="info-card">
                <h2>📋 Detalles de tu reparación</h2>
                <ul>
                    <li><strong>Falla reportada:</strong> {{ $reparacion->falla_reportada }}</li>
                    <li><strong>Costo total:</strong> <span class="highlight">L. {{ number_format($reparacion->costo_total, 2) }}</span></li>
                    <li><strong>Abono actual:</strong> L. {{ number_format($reparacion->abono, 2) }}</li>
                    <li><strong>Saldo pendiente:</strong> <span class="highlight">L. {{ number_format($reparacion->costo_total - $reparacion->abono, 2) }}</span></li>
                </ul>
            </div>
            
            <p>Puedes pasar por nuestro local a retirar tu dispositivo. Si existe saldo pendiente, podrás cancelarlo al momento de la entrega.</p>
            
            <p style="text-align: center;">
                <a href="https://maps.google.com/?q=TavoCell504" class="btn">📍 Ver ubicación</a>
            </p>
            
            <p><strong>Horario de atención:</strong><br>
            Lunes a Sábado: 8:30 AM - 5PM PM<br>
            Domingo: CERRADO PM</p>
        </div>
        
        <!-- Pie de página -->
        <div class="footer">
            <p>Gracias por confiar en <strong>TavoCell 504</strong> 🔧</p>
            <p>"Honradez, Calidad y Servicio"</p>
            <p>📞 +504 3238-4184 | 📧 info@tavocell504.com</p>
            <p>© {{ date('Y') }} TavoCell 504. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
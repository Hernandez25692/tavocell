@extends('layouts.app')

@section('title', 'Seguimiento de Reparación - TavoCell 504')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8 px-4 sm:px-6">
    <div class="max-w-4xl mx-auto animate-fade-in">
        <!-- Tarjeta principal con identidad de marca -->
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden border-2 border-tavocell-primary transform transition-all duration-500 hover:shadow-3xl">
            <!-- Encabezado con marca TavoCell -->
            <div class="bg-tavocell-primary p-6 text-white relative">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center">
                        <img src="{{ asset('Logo/logo_menu.png') }}" alt="TavoCell 504" class="h-12 mr-4">
                        <div>
                            <h1 class="text-2xl font-bold">Seguimiento de Reparación #{{ $reparacion->id }}</h1>
                            <p class="text-tavocell-light text-sm mt-1">"Honradez, Calidad y Servicio"</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/20 backdrop-blur-sm">
                        {{ ucfirst($reparacion->estado) }}
                    </span>
                </div>
            </div>

            <!-- Información de la reparación -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Datos del cliente -->
                <div class="bg-tavocell-light-bg p-4 rounded-lg border border-tavocell-border">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-tavocell-secondary text-white p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-500">Cliente</h3>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $reparacion->cliente->nombre ?? 'Cliente no identificado' }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">Tel: {{ $reparacion->cliente->telefono ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Datos del dispositivo -->
                <div class="bg-tavocell-light-bg p-4 rounded-lg border border-tavocell-border">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-tavocell-secondary text-white p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-500">Dispositivo</h3>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $reparacion->marca }} {{ $reparacion->modelo }}
                            </p>
                            @if($reparacion->imei)
                            <p class="text-xs text-gray-500 mt-1">IMEI: {{ $reparacion->imei }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Información financiera -->
                <div class="bg-tavocell-light-bg p-4 rounded-lg border border-tavocell-border">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-tavocell-secondary text-white p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-500">Información Financiera</h3>
                            <p class="text-sm text-gray-800"><span class="font-semibold">Costo:</span> L. {{ number_format($reparacion->costo_total, 2) }}</p>
                            <p class="text-sm text-gray-800"><span class="font-semibold">Abono:</span> L. {{ number_format($reparacion->abono, 2) }}</p>
                            <p class="text-sm text-gray-800"><span class="font-semibold">Saldo:</span> <span class="font-bold {{ ($reparacion->costo_total - $reparacion->abono) > 0 ? 'text-red-600' : 'text-green-600' }}">L. {{ number_format($reparacion->costo_total - $reparacion->abono, 2) }}</span></p>
                        </div>
                    </div>
                </div>

                <!-- Estado y fecha -->
                <div class="bg-tavocell-light-bg p-4 rounded-lg border border-tavocell-border">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-tavocell-secondary text-white p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-500">Estado y Fechas</h3>
                            <p class="text-sm text-gray-800"><span class="font-semibold">Ingreso:</span> {{ \Carbon\Carbon::parse($reparacion->fecha_ingreso)->isoFormat('D MMM YYYY') }}</p>
                            @if($reparacion->fecha_entrega)
                            <p class="text-sm text-gray-800"><span class="font-semibold">Entrega estimada:</span> {{ \Carbon\Carbon::parse($reparacion->fecha_entrega)->isoFormat('D MMM YYYY') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historial de seguimiento con línea de tiempo -->
            <div class="border-t border-gray-200/50 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-tavocell-primary mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Historial de Seguimiento
                </h2>

                @if($reparacion->seguimientos->isEmpty())
                    <div class="text-center py-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay seguimientos registrados</h3>
                        <p class="mt-1 text-sm text-gray-500">Aún no se han agregado actualizaciones a esta reparación.</p>
                    </div>
                @else
                    <div class="relative">
                        <!-- Línea vertical -->
                        <div class="absolute left-6 top-0 h-full w-0.5 bg-tavocell-primary/20"></div>
                        
                        <div class="space-y-6 pl-8">
                            @foreach($reparacion->seguimientos as $seg)
                            <div class="relative">
                                <!-- Punto de la línea de tiempo -->
                                <div class="absolute -left-2 top-1/2 transform -translate-y-1/2 w-4 h-4 bg-tavocell-primary rounded-full border-4 border-white shadow-md"></div>
                                
                                <!-- Tarjeta de seguimiento -->
                                <div class="bg-tavocell-light-bg border border-tavocell-border rounded-xl p-4 shadow-sm transition-all duration-300 hover:border-tavocell-primary">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm text-gray-800">{{ $seg->descripcion }}</p>
                                            <p class="text-xs text-gray-500 mt-2"><span class="font-semibold">Técnico:</span> {{ $seg->tecnico->name ?? 'Sistema' }}</p>
                                        </div>
                                        <span class="text-xs text-gray-500 whitespace-nowrap">
                                            {{ $seg->created_at->isoFormat('D MMM, h:mm a') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Políticas de la empresa -->
            <div class="border-t border-gray-200/50 p-6 bg-tavocell-light-bg">
                <h2 class="text-lg font-bold text-tavocell-primary mb-3">📜 Políticas de TavoCell 504</h2>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start">
                        <span class="text-tavocell-primary mr-2">•</span>
                        <span>Todas las reparaciones tienen 30 días de garantía sobre las piezas instaladas</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-tavocell-primary mr-2">•</span>
                        <span>El cliente debe retirar su dispositivo dentro de los 15 días posteriores a la notificación de reparación terminada</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-tavocell-primary mr-2">•</span>
                        <span>No nos hacemos responsables por datos perdidos durante el proceso de reparación</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-tavocell-primary mr-2">•</span>
                        <span>Para reclamos debe presentar su factura y documento de identidad</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-tavocell-primary mr-2">•</span>
                        <span>Horario de atención: Lunes a Sábado: 8:30 AM - 5PM | Domingo: CERRADO</span>
                    </li>
                </ul>
            </div>

            <!-- Información de contacto -->
            <div class="border-t border-gray-200/50 p-6 bg-tavocell-primary text-white">
                <h2 class="text-lg font-bold mb-3">📞 Contacto</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>+504 3238-4184</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>info@tavocell504.com</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>San Jeronimo, Namasigue, Choluteca</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Lunes a Sábado: 8:30 AM - 5PM | Domingo: CERRADO</span>
                    </div>
                </div>
            </div>

            <!-- Botón de volver -->
            <div class="bg-gray-50 p-4 text-center">
                <a href="{{ route('reparaciones.index') }}" class="inline-flex items-center bg-tavocell-primary hover:bg-tavocell-dark text-white px-6 py-2 rounded-lg font-medium shadow-md transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver al listado
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --tavocell-primary: #2563eb;
        --tavocell-dark: #1e40af;
        --tavocell-secondary: #f59e0b;
        --tavocell-light: #93c5fd;
        --tavocell-light-bg: #f8fafc;
        --tavocell-border: #e2e8f0;
    }

    .bg-tavocell-primary {
        background-color: var(--tavocell-primary);
    }
    
    .bg-tavocell-dark {
        background-color: var(--tavocell-dark);
    }
    
    .bg-tavocell-secondary {
        background-color: var(--tavocell-secondary);
    }
    
    .bg-tavocell-light {
        background-color: var(--tavocell-light);
    }
    
    .bg-tavocell-light-bg {
        background-color: var(--tavocell-light-bg);
    }
    
    .border-tavocell-border {
        border-color: var(--tavocell-border);
    }
    
    .text-tavocell-primary {
        color: var(--tavocell-primary);
    }
    
    .text-tavocell-light {
        color: var(--tavocell-light);
    }

    .animate-fade-in {
        animation: fadeIn 0.6s cubic-bezier(0.39, 0.575, 0.565, 1) both;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .shadow-3xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }

    /* Scroll personalizado */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: var(--tavocell-primary);
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: var(--tavocell-dark);
    }
</style>
@endsection
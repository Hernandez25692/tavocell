@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-xl font-bold mb-4">📱 Reparaciones de {{ $cliente->nombre }}</h1>

    @foreach($reparaciones as $rep)
        <div class="bg-white p-4 rounded shadow mb-4">
            <h2 class="text-lg font-semibold">#{{ $rep->id }} - {{ $rep->marca }} {{ $rep->modelo }}</h2>
            <p><strong>Falla:</strong> {{ $rep->falla_reportada }}</p>
            <p><strong>Estado actual:</strong> {{ ucfirst($rep->estado) }}</p>
            <p><strong>Fecha ingreso:</strong> {{ $rep->fecha_ingreso }}</p>

            @if($rep->seguimientos->isNotEmpty())
                <h4 class="mt-3 font-semibold">📋 Avances técnicos:</h4>
                <ul class="ml-4 list-disc">
                    @foreach($rep->seguimientos as $seg)
                        <li>
                            <strong>{{ $seg->fecha_avance }} - {{ ucfirst($seg->estado) }}</strong><br>
                            {{ $seg->descripcion }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-600 mt-2">Aún no hay seguimiento técnico.</p>
            @endif
        </div>
    @endforeach

    <a href="{{ route('consulta.reparacion') }}" class="btn btn-secondary">← Consultar otro</a>
</div>
@endsection

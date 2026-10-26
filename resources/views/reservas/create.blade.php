@extends('layout')
@section('title', 'Reserva de boletas')

@section('content')
{{-- ========== PASO 2: contenedor general, título y subtítulo ========== --}}
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="page-title text-center mb-3">Reserva de boletas</h1>
            <p class="page-subtitle text-center mb-5">
                Elige tu película, el formato de proyección y tus snacks favoritos.
            </p>

            {{-- Mensajes de éxito / error del guardado (los llena el JS del Paso 6) --}}
            <div id="alertaEstado" class="alert d-none" role="alert"></div>

            {{-- ========== PASO 5: zona de resultados (oculta hasta enviar) ========== --}}
            <div id="resultados" class="mt-5" style="display: none;">
                <div class="card cine-card results-card">
                    <div class="card-header">
                        <h5 class="mb-0">🎟️ Resumen de tu reserva</h5>
                    </div>
                    <div class="card-body" id="contenidoResultados"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
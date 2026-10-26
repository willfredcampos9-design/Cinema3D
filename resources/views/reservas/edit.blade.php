@extends('layout')
@section('title', 'Editar reserva')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="page-title text-center mb-5">Editar reserva</h1>

            <div class="card cine-card">
                <div class="card-body p-4">
                    <form id="formularioEditar" action="{{ route('reservas.update', $reserva) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('reservas._form')

                        <div class="d-grid gap-2 d-md-flex">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <a href="{{ route('reservas.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

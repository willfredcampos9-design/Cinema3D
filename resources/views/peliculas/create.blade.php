@extends('layout')
@section('title', 'Nueva película')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="page-title text-center mb-5">Registro de película</h1>
            <div class="card cine-card">
                <div class="card-body">
                    <form id="form" action="{{ route('peliculas.store') }}" method="POST">
                        @csrf
                        @include('peliculas._form', ['pelicula' => null])
                        <button class="btn btn-primary">Guardar</button>
                        <a href="{{ route('peliculas.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layout')
@section('title', 'Editar película')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="page-title text-center mb-5">Editar película</h1>
            <div class="card cine-card">
                <div class="card-body">
                    <form id="form" action="{{ route('peliculas.update', $pelicula) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('peliculas._form')
                        <button class="btn btn-primary">Actualizar</button>
                        <a href="{{ route('peliculas.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

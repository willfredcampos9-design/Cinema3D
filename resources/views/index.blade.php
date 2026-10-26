@extends('layout')
@section('title', 'Cinema3D')
@section('content')
    <div class="container py-5 text-center">
        <h1 class="page-title display-4 mb-3">Bienvenidos a Cinema3D</h1>
        <p class="page-subtitle fs-5 mb-4">Tu cine favorito: consulta la cartelera y reserva tus boletas en 2D o 3D.</p>
        <a href="{{ route('reservas.create') }}" class="btn btn-primary btn-lg">🎟️ Reservar boletas</a>
        <a href="{{ route('peliculas.index') }}" class="btn btn-outline-light btn-lg">Ver cartelera</a>
    </div>
@endsection
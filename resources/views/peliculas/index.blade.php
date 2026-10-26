@extends('layout')
@section('title', 'Cartelera')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title h2 mb-0">Cartelera</h1>
        <a href="{{ route('peliculas.create') }}" class="btn btn-primary">Nueva película</a>
    </div>

    @if (session('type'))
        <div class="alert alert-{{ session('type') }} alert-dismissible fade show" role="alert">
            <strong>Noticia:</strong> {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card cine-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Sinopsis</th>
                        <th>Duración</th>
                        <th>Clasificación</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peliculas as $pelicula)
                        <tr>
                            <td class="fw-semibold">{{ $pelicula->titulo }}</td>
                            <td>{{ $pelicula->sinopsis }}</td>
                            <td>{{ $pelicula->duracion_minutos }} min</td>
                            <td><span class="badge text-bg-dark">{{ $pelicula->clasificacion }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('peliculas.edit', $pelicula) }}" class="btn btn-sm btn-info">Editar</a>
                                <form action="{{ route('peliculas.destroy', $pelicula) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Quiere eliminar la película?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No hay películas en cartelera.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

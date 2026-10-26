@extends('layout')
@section('title', 'Reservas')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title h2 mb-0">Reservas</h1>
        <a href="{{ route('reservas.create') }}" class="btn btn-primary">Nueva reserva</a>
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
                        <th>Cliente</th>
                        <th>Película</th>
                        <th>Función</th>
                        <th>Boletas</th>
                        <th>Formato</th>
                        <th>Estudiante</th>
                        <th>Snacks</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reservas as $reserva)
                        <tr>
                            <td>{{ $reserva->nombres }} {{ $reserva->apellidos }}</td>
                            <td>{{ $reserva->pelicula->titulo }}</td>
                            <td>{{ $reserva->fecha_funcion->format('d/m/Y') }}</td>
                            <td>{{ $reserva->cantidad_boletas }}</td>
                            <td><span class="badge text-bg-dark">{{ $reserva->formato }}</span></td>
                            <td>{{ $reserva->es_estudiante ? 'Sí' : 'No' }}</td>
                            <td>
                                @forelse ($reserva->snacks as $snack)
                                    <span class="badge text-bg-warning">{{ $snack->nombre }}</span>
                                @empty
                                    <span class="text-muted">—</span>
                                @endforelse
                            </td>
                            <td class="text-end">
                                <a href="{{ route('reservas.edit', $reserva) }}" class="btn btn-sm btn-info">Editar</a>
                                <form action="{{ route('reservas.destroy', $reserva) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Quiere eliminar la reserva?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">Aún no hay reservas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

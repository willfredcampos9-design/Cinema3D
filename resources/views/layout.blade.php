{{-- PASO 1: estructura base + CDN de Bootstrap 5 --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cinema3D')</title>
    <!-- Hoja de estilos de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
          crossorigin="anonymous">
    <link href="{{ asset('css/cinema.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
    <nav class="navbar navbar-expand-md cine-nav">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">🎬 Cinema<span>3D</span></a>
            <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse"
                    data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false"
                    aria-label="Mostrar menú">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuPrincipal">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('peliculas.index') }}">Cartelera</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('reservas.index') }}">Reservas</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('reservas.create') }}">Reservar boletas</a></li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Bundle JavaScript de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>
    @yield('js')
</body>
</html>

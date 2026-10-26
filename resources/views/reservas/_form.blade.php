{{-- Campos compartidos por create.blade.php y edit.blade.php --}}
@php
    $formato = old('formato', $reserva?->formato ?? '2D');
    $estudiante = old('estudiante', ($reserva?->es_estudiante ?? false) ? 'Sí' : 'No');
    $marcados = old('snacks', $reserva?->snacks->pluck('id')->all() ?? []);
@endphp

{{-- ========== PASO 3: campos de texto / fecha / número (+ película) ========== --}}

<!-- Nombres -->
<div class="mb-3">
    <label for="nombres" class="form-label">Nombres</label>
    <input type="text" class="form-control @error('nombres') is-invalid @enderror"
           id="nombres" name="nombres" value="{{ old('nombres', $reserva?->nombres) }}" maxlength="80" required>
    @error('nombres') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<!-- Apellidos -->
<div class="mb-3">
    <label for="apellidos" class="form-label">Apellidos</label>
    <input type="text" class="form-control @error('apellidos') is-invalid @enderror"
           id="apellidos" name="apellidos" value="{{ old('apellidos', $reserva?->apellidos) }}" maxlength="80" required>
    @error('apellidos') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<!-- Película (cargada desde la cartelera) -->
<div class="mb-3">
    <label for="pelicula" class="form-label">Película</label>
    <select class="form-select @error('pelicula_id') is-invalid @enderror" id="pelicula" name="pelicula_id" required>
        <option value="" disabled @selected(! old('pelicula_id', $reserva?->pelicula_id))>Seleccione una película</option>
        @foreach ($peliculas as $pelicula)
            <option value="{{ $pelicula->id }}"
                @selected((int) old('pelicula_id', $reserva?->pelicula_id) === $pelicula->id)>
                {{ $pelicula->titulo }} ({{ $pelicula->clasificacion }})
            </option>
        @endforeach
    </select>
    @error('pelicula_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<!-- Fecha de la función -->
<div class="mb-3">
    <label for="fechaFuncion" class="form-label">Fecha de la función</label>
    <input type="date" class="form-control @error('fecha_funcion') is-invalid @enderror"
           id="fechaFuncion" name="fecha_funcion"
           value="{{ old('fecha_funcion', $reserva?->fecha_funcion?->format('Y-m-d')) }}"
           @if (! $reserva) min="{{ now()->toDateString() }}" @endif required>
    @error('fecha_funcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<!-- Cantidad de boletas -->
<div class="mb-3">
    <label for="boletas" class="form-label">Cantidad de boletas</label>
    <input type="number" class="form-control @error('cantidad_boletas') is-invalid @enderror"
           id="boletas" name="cantidad_boletas" min="1" max="10"
           value="{{ old('cantidad_boletas', $reserva?->cantidad_boletas ?? 1) }}" required>
    @error('cantidad_boletas') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

{{-- ========== PASO 4: radios inline y checkboxes ========== --}}

<!-- Formato de proyección (Radio Inline) -->
<div class="mb-3">
    <label class="form-label d-block">Formato de proyección</label>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="formato" id="formato2d" value="2D" @checked($formato === '2D')>
        <label class="form-check-label" for="formato2d">2D</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="formato" id="formato3d" value="3D" @checked($formato === '3D')>
        <label class="form-check-label" for="formato3d">3D</label>
    </div>
    @error('formato') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<!-- Carné de estudiante (Radio Inline) -->
<div class="mb-3">
    <label class="form-label d-block">¿Tiene carné de estudiante?</label>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="estudiante" id="estudianteSi" value="Sí" @checked($estudiante === 'Sí')>
        <label class="form-check-label" for="estudianteSi">Sí</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="estudiante" id="estudianteNo" value="No" @checked($estudiante === 'No')>
        <label class="form-check-label" for="estudianteNo">No</label>
    </div>
    @error('estudiante') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<!-- Snacks (Checkboxes en rejilla de 3 columnas, cargados desde la BD) -->
<div class="mb-4">
    <label class="form-label d-block">Snacks para la función:</label>
    <div class="row">
        @foreach ($snacks->chunk(max(1, (int) ceil($snacks->count() / 3))) as $columna)
            <div class="col-md-4">
                @foreach ($columna as $snack)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="snacks[]"
                               value="{{ $snack->id }}" id="snack{{ $snack->id }}"
                               @checked(in_array($snack->id, $marcados))>
                        <label class="form-check-label" for="snack{{ $snack->id }}">{{ $snack->nombre }}</label>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
    @error('snacks') <div class="text-danger small">{{ $message }}</div> @enderror
</div>
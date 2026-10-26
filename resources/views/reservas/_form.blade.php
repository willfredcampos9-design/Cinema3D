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
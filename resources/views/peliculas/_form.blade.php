<div class="mb-3">
    <label for="titulo" class="form-label">Título</label>
    <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo" name="titulo"
           value="{{ old('titulo', $pelicula?->titulo) }}" maxlength="100" required>
    @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="sinopsis" class="form-label">Sinopsis</label>
    <textarea class="form-control @error('sinopsis') is-invalid @enderror" id="sinopsis" name="sinopsis"
              rows="3" maxlength="255" required>{{ old('sinopsis', $pelicula?->sinopsis) }}</textarea>
    @error('sinopsis') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="duracion" class="form-label">Duración (minutos)</label>
        <input type="number" class="form-control @error('duracion_minutos') is-invalid @enderror" id="duracion"
               name="duracion_minutos" min="1" max="400" value="{{ old('duracion_minutos', $pelicula?->duracion_minutos) }}" required>
        @error('duracion_minutos') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-4">
        <label for="clasificacion" class="form-label">Clasificación</label>
        <select class="form-select @error('clasificacion') is-invalid @enderror" id="clasificacion" name="clasificacion" required>
            @foreach (['TP', '+7', '+12', '+15', '+18'] as $c)
                <option value="{{ $c }}" @selected(old('clasificacion', $pelicula?->clasificacion ?? 'TP') === $c)>{{ $c }}</option>
            @endforeach
        </select>
        @error('clasificacion') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

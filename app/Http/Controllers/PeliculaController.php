<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;

class PeliculaController extends Controller
{
    public function index()
    {
        $peliculas = Pelicula::orderBy('titulo')->get();

        return view('peliculas.index', compact('peliculas'));
    }

    public function create()
    {
        return view('peliculas.create');
    }

    public function store(Request $request)
    {
        Pelicula::create($this->validar($request));

        return redirect()->route('peliculas.index')
            ->with('type', 'success')
            ->with('message', 'Película creada exitosamente');
    }

    public function edit(Pelicula $pelicula)
    {
        return view('peliculas.edit', compact('pelicula'));
    }

    public function update(Request $request, Pelicula $pelicula)
    {
        $pelicula->update($this->validar($request));

        return redirect()->route('peliculas.index')
            ->with('type', 'warning')
            ->with('message', 'Película actualizada exitosamente');
    }

    public function destroy(Pelicula $pelicula)
    {
        if ($pelicula->reservas()->exists()) {
            return redirect()->route('peliculas.index')
                ->with('type', 'danger')
                ->with('message', 'No se puede eliminar: la película tiene reservas asociadas');
        }

        $pelicula->delete();

        return redirect()->route('peliculas.index')
            ->with('type', 'danger')
            ->with('message', 'La película se eliminó');
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'titulo' => 'required|string|max:100',
            'sinopsis' => 'required|string|max:255',
            'duracion_minutos' => 'required|integer|min:1|max:400',
            'clasificacion' => 'required|in:TP,+7,+12,+15,+18',
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'max' => 'El campo :attribute no es válido (máximo :max).',
            'min' => 'El campo :attribute debe ser como mínimo :min.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'in' => 'El valor seleccionado en :attribute no es válido.',
        ], [
            'titulo' => 'título',
            'duracion_minutos' => 'duración (minutos)',
            'clasificacion' => 'clasificación',
        ]);
    }
}

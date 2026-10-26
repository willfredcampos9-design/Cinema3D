<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Reserva;
use App\Models\Snack;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    /** Listado de reservas */
    public function index()
    {
        $reservas = Reserva::with(['pelicula', 'snacks'])->latest()->get();

        return view('reservas.index', compact('reservas'));
    }

    /** Formulario "Reserva de boletas" (Pasos 2 a 6 de la guía) */
    public function create()
    {
        $peliculas = Pelicula::orderBy('titulo')->get();
        $snacks = Snack::orderBy('id')->get();

        return view('reservas.create', compact('peliculas', 'snacks'));
    }

    /** Guarda la reserva. Responde JSON si viene del fetch del Paso 6 */
    public function store(Request $request)
    {
        $validado = $this->validar($request, true);

        $reserva = Reserva::create($this->atributos($validado));
        $reserva->snacks()->sync($validado['snacks'] ?? []);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Reserva creada exitosamente', 'id' => $reserva->id], 201);
        }

        return redirect()->route('reservas.index')
            ->with('type', 'success')
            ->with('message', 'Reserva creada exitosamente');
    }

    public function edit(Reserva $reserva)
    {
        $reserva->load('snacks');
        $peliculas = Pelicula::orderBy('titulo')->get();
        $snacks = Snack::orderBy('id')->get();

        return view('reservas.edit', compact('reserva', 'peliculas', 'snacks'));
    }

    public function update(Request $request, Reserva $reserva)
    {
        $validado = $this->validar($request, false);

        $reserva->update($this->atributos($validado));
        $reserva->snacks()->sync($validado['snacks'] ?? []);

        return redirect()->route('reservas.index')
            ->with('type', 'warning')
            ->with('message', 'Reserva actualizada exitosamente');
    }

    public function destroy(Reserva $reserva)
    {
        $reserva->delete(); // la tabla pivote se limpia por cascade

        return redirect()->route('reservas.index')
            ->with('type', 'danger')
            ->with('message', 'La reserva se eliminó');
    }

    /** Validación en el servidor (la fecha no puede ser pasada solo al crear) */
    private function validar(Request $request, bool $nueva): array
    {
        return $request->validate([
            'nombres' => 'required|string|max:80',
            'apellidos' => 'required|string|max:80',
            'pelicula_id' => 'required|exists:peliculas,id',
            'fecha_funcion' => $nueva ? 'required|date|after_or_equal:today' : 'required|date',
            'cantidad_boletas' => 'required|integer|min:1|max:10',
            'formato' => 'required|in:2D,3D',
            'estudiante' => 'required|in:Sí,No',
            'snacks' => 'nullable|array',
            'snacks.*' => 'integer|exists:snacks,id',
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'max' => 'El campo :attribute no es válido (máximo :max).',
            'min' => 'El campo :attribute debe ser como mínimo :min.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'date' => 'El campo :attribute no es una fecha válida.',
            'after_or_equal' => 'La :attribute no puede ser anterior a hoy.',
            'in' => 'El valor seleccionado en :attribute no es válido.',
            'exists' => 'La opción seleccionada en :attribute no existe.',
        ], [
            'pelicula_id' => 'película',
            'fecha_funcion' => 'fecha de la función',
            'cantidad_boletas' => 'cantidad de boletas',
            'formato' => 'formato de proyección',
            'estudiante' => '¿tiene carné de estudiante?',
        ]);
    }

    /** Traduce el formulario a las columnas de la tabla reservas */
    private function atributos(array $v): array
    {
        return [
            'nombres' => $v['nombres'],
            'apellidos' => $v['apellidos'],
            'pelicula_id' => $v['pelicula_id'],
            'fecha_funcion' => $v['fecha_funcion'],
            'cantidad_boletas' => $v['cantidad_boletas'],
            'formato' => $v['formato'],
            'es_estudiante' => $v['estudiante'] === 'Sí',
        ];
    }
}

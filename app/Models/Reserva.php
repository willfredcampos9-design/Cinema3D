<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reserva extends Model
{
    protected $fillable = [
        'nombres',
        'apellidos',
        'pelicula_id',
        'fecha_funcion',
        'cantidad_boletas',
        'formato',
        'es_estudiante',
    ];

    protected function casts(): array
    {
        return [
            'fecha_funcion' => 'date',
            'es_estudiante' => 'boolean',
        ];
    }

    public function pelicula(): BelongsTo
    {
        return $this->belongsTo(Pelicula::class);
    }

    public function snacks(): BelongsToMany
    {
        return $this->belongsToMany(Snack::class, 'reserva_snack');
    }
}

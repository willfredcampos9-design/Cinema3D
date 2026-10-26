<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelicula extends Model
{
    protected $fillable = ['titulo', 'sinopsis', 'duracion_minutos', 'clasificacion'];

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class);
    }
}

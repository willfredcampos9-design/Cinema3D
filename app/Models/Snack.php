<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Snack extends Model
{
    protected $fillable = ['nombre'];

    public function reservas(): BelongsToMany
    {
        return $this->belongsToMany(Reserva::class, 'reserva_snack');
    }
}

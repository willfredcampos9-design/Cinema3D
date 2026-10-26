<?php

namespace Database\Seeders;

use App\Models\Pelicula;
use Illuminate\Database\Seeder;

class PeliculaSeeder extends Seeder
{
    public function run(): void
    {
        $peliculas = [
            ['Intensamente 2', 'Riley crece y llegan nuevas emociones que complican su vida.', 96, 'TP'],
            ['Duna: Parte Dos', 'Paul Atreides se une a los Fremen en su lucha por Arrakis.', 166, '+12'],
            ['Mi Villano Favorito 4', 'Gru y su familia enfrentan a un nuevo enemigo del pasado.', 95, 'TP'],
        ];

        foreach ($peliculas as [$titulo, $sinopsis, $duracion, $clasificacion]) {
            Pelicula::firstOrCreate(
                ['titulo' => $titulo],
                ['sinopsis' => $sinopsis, 'duracion_minutos' => $duracion, 'clasificacion' => $clasificacion]
            );
        }
    }
}

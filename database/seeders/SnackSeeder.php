<?php

namespace Database\Seeders;

use App\Models\Snack;
use Illuminate\Database\Seeder;

class SnackSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Crispetas', 'Gaseosa', 'Nachos', 'Perro caliente', 'Dulces', 'Helado'] as $nombre) {
            Snack::firstOrCreate(['nombre' => $nombre]);
        }
    }
}

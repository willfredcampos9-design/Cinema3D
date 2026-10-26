<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\ReservaController;

Route::get('/', function () {
    return view('index');
});

// Cartelera (módulo estilo Mercadosena: CRUD completo)
Route::resource('peliculas', PeliculaController::class)->except('show');

// Reservas de boletas (formulario de la guía de aprendizaje, tematizado en cine)
Route::resource('reservas', ReservaController::class)->except('show');
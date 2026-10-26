<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 80);
            $table->string('apellidos', 80);
            $table->foreignId('pelicula_id')->constrained('peliculas')->restrictOnDelete();
            $table->date('fecha_funcion');
            $table->unsignedTinyInteger('cantidad_boletas');
            $table->string('formato', 2)->default('2D'); // 2D o 3D
            $table->boolean('es_estudiante')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};

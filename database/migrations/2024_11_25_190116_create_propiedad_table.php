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
        Schema::create('propiedad', function (Blueprint $table) {
            $table->id();
            $table->integer('ID_Usuario');
            $table->string('Direccion');
            $table->string('Estado');
            $table->string('Municipio');            
            $table->string('Calificacion')->nullable();
            $table->string('Reseñas')->nullable();
            $table->string('Precio_Renta');
            $table->string('Descripcion');
            $table->string('Tipo');
            $table->string('Estatus');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propiedad');
    }
};

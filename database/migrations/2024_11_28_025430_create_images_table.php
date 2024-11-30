<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('propiedad_id') // Relación con la tabla de propiedades
                  ->constrained('propiedad') // Referencia a la tabla `propiedades`
                  ->onDelete('cascade'); // Eliminar imágenes si se elimina la propiedad
            $table->string('path'); // Ruta de la imagen almacenada
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};

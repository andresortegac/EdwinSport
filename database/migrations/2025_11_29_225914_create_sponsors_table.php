<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // nombre del patrocinador
            $table->string('image');         // ruta de la imagen
            $table->string('url')->nullable(); // link opcional
            $table->string('position')->default('events_sidebar'); // dónde se muestra
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};


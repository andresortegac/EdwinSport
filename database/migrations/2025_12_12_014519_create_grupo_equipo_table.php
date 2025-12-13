<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grupo_equipo', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('grupo_id');
            $table->unsignedBigInteger('equipo_id');

            $table->timestamps();

            // Índices
            $table->index('grupo_id');
            $table->index('equipo_id');

            // Evita duplicados del mismo equipo en un grupo
            $table->unique(['grupo_id', 'equipo_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grupo_equipo');
    }
};

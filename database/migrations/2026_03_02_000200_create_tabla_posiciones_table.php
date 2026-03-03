<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tabla_posiciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competicion_id');
            $table->unsignedBigInteger('grupo_id');
            $table->unsignedBigInteger('equipo_id');
            $table->unsignedInteger('pj')->default(0);
            $table->unsignedInteger('pg')->default(0);
            $table->unsignedInteger('pe')->default(0);
            $table->unsignedInteger('pp')->default(0);
            $table->unsignedInteger('gf')->default(0);
            $table->unsignedInteger('gc')->default(0);
            $table->integer('dg')->default(0);
            $table->unsignedInteger('puntos')->default(0);
            $table->timestamps();

            $table->index('competicion_id');
            $table->index('grupo_id');
            $table->index('equipo_id');
            $table->unique(
                ['competicion_id', 'grupo_id', 'equipo_id'],
                'tabla_posiciones_comp_grupo_equipo_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tabla_posiciones');
    }
};

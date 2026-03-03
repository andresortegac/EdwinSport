<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competicion_id');
            $table->unsignedBigInteger('grupo_id');
            $table->unsignedBigInteger('equipo_local_id');
            $table->unsignedBigInteger('equipo_visitante_id');
            $table->unsignedTinyInteger('goles_local')->nullable();
            $table->unsignedTinyInteger('goles_visitante')->nullable();
            $table->timestamp('jugado_en')->nullable();
            $table->timestamps();

            $table->index('competicion_id');
            $table->index('grupo_id');
            $table->index('equipo_local_id');
            $table->index('equipo_visitante_id');
            $table->unique(
                ['competicion_id', 'grupo_id', 'equipo_local_id', 'equipo_visitante_id'],
                'partidos_comp_grupo_local_visitante_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partidos');
    }
};

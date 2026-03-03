<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partidos_eliminacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competicion_id');
            $table->unsignedInteger('ronda');
            $table->unsignedInteger('slot');
            $table->unsignedBigInteger('equipo_local_id')->nullable();
            $table->unsignedBigInteger('equipo_visitante_id')->nullable();
            $table->unsignedTinyInteger('goles_local')->nullable();
            $table->unsignedTinyInteger('goles_visitante')->nullable();
            $table->unsignedBigInteger('ganador_id')->nullable();
            $table->timestamp('jugado_en')->nullable();
            $table->timestamps();

            $table->index('competicion_id');
            $table->index('ronda');
            $table->index('slot');
            $table->index('equipo_local_id');
            $table->index('equipo_visitante_id');
            $table->index('ganador_id');
            $table->unique(
                ['competicion_id', 'ronda', 'slot'],
                'partidos_eliminacion_comp_ronda_slot_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partidos_eliminacion');
    }
};

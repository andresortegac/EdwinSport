<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cancha_id')->constrained('canchas')->onDelete('cascade');
            $table->unsignedBigInteger('subcancha_id')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->string('nombre_cliente')->nullable();
            $table->string('telefono_cliente')->nullable();
            $table->timestamps();

            $table->unique(['cancha_id','fecha','hora_inicio']);
            $table->unique(['subcancha_id', 'fecha', 'hora_inicio'], 'unique_reserva_subcancha_fecha_hora');
        });
    }

    public function down() {
        Schema::dropIfExists('reservas');
    }
};

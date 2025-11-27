<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cancha_id')->constrained('canchas')->onDelete('cascade');
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->string('nombre_cliente')->nullable();
            $table->string('telefono_cliente')->nullable();
            $table->timestamps();

            $table->unique(['cancha_id','fecha','hora_inicio']);
        });
    }

    public function down() {
        Schema::dropIfExists('reservas');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('canchas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('telefono_contacto')->nullable();
            $table->time('hora_apertura')->default('07:00:00');
            $table->time('hora_cierre')->default('22:00:00');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('canchas');
    }
};

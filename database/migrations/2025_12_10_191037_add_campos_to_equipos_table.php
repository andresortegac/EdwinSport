<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_equipo');
            $table->string('nit');
            $table->string('direccion');
            $table->string('telefono_equipo');
            $table->string('email_equipo');
            $table->integer('valor_inscripcion');
            $table->string('nombre_dt');
            // si NO usas timestamps, no los pongas
            // $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};

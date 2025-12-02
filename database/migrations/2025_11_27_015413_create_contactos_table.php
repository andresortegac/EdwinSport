<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contactenos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->string('nombre_completo');
            $table->string('documento');
            $table->string('telefono_natural')->nullable();
            $table->string('correo_electronico');
            $table->string('razon_social')->nullable();
            $table->string('evento_nombre')->nullable();
            $table->string('categoria');
            $table->text('descripcion')->nullable();
            $table->date('fecha_inicial')->nullable();
            $table->date('fecha_final')->nullable();
            $table->timestamps();
            $table->boolean('leido')->default(false);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contactenos');
    }
};

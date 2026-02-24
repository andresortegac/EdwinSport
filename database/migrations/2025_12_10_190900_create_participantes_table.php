<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->nullable()->constrained('equipos')->nullOnDelete();
            $table->string('nombre');
            $table->string('numero_camisa', 10)->nullable();
            $table->string('evento')->nullable();
            $table->unsignedTinyInteger('edad')->nullable();
            $table->string('division')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono', 30)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participantes');
    }
};

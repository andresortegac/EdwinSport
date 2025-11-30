<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participantes', function (Blueprint $table) {
            $table->id(); // id BIGINT unsigned auto_increment

            $table->string('nombre');
            $table->string('evento');
            $table->integer('edad');
            $table->string('equipo');
            $table->string('division');
            $table->string('email');
            $table->string('telefono');

            // en tu tabla están en NULL, así que los dejo nullable
            $table->timestamps(); 
            // si quieres forzar nullable explícito:
            // $table->timestamp('created_at')->nullable();
            // $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participantes');
    }
};

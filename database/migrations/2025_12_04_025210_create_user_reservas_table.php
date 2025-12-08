<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('user_reservas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('cancha_id');
        $table->string('nombre_cliente');
        $table->string('telefono_cliente')->nullable();
        $table->date('fecha');
        $table->time('hora');
        $table->integer('numero_subcancha')->nullable();
        $table->timestamps();

        $table->foreign('cancha_id')->references('id')->on('canchas')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_reservas');
    }
};

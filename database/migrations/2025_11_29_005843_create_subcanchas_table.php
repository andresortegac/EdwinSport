<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('subcanchas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cancha_id');
            $table->string('nombre')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('cancha_id')->references('id')->on('canchas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subcanchas');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('logo')->nullable(); // ruta de imagen
            $table->string('url')->nullable();  // opcional: web del sponsor
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('sponsors');
    }
};

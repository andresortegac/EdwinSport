<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('canchas', function (Blueprint $table) {
        $table->string('ubicacion')->nullable();
        $table->string('telefono_contacto')->nullable();
        $table->time('hora_apertura')->default('06:00');
        $table->time('hora_cierre')->default('22:00');
    });
    }

    
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('competiciones', function (Blueprint $table) {

            // ID del evento (igual que equipos.evento)
            $table->unsignedBigInteger('evento')
                  ->after('id');

            // Estado de la competición
            $table->string('estado')
                  ->default('creada')
                  ->after('evento');

            // Índice para búsquedas
            $table->index('evento');
        });
    }

    public function down(): void
    {
        Schema::table('competiciones', function (Blueprint $table) {

            $table->dropIndex(['evento']);
            $table->dropColumn(['evento', 'estado']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->unsignedBigInteger('subcancha_id')->nullable()->after('cancha_id');

            $table->foreign('subcancha_id')->references('id')->on('subcanchas')->onDelete('set null');

            // evita doble reserva en misma subcancha, misma fecha y misma hora
            $table->unique(['subcancha_id', 'fecha', 'hora_inicio'], 'unique_reserva_subcancha_fecha_hora');
        });
    }

    public function down()
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropUnique('unique_reserva_subcancha_fecha_hora');
            $table->dropForeign(['subcancha_id']);
            $table->dropColumn('subcancha_id');
        });
    }
};

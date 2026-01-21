<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('grupos', function (Blueprint $table) {

            // 1?? Agregar relación con competición
            $table->unsignedBigInteger('competicion_id')
                  ->after('id')
                  ->nullable();

            // 2?? Renombrar columna nombre ? nombre_grupo
            $table->renameColumn('nombre', 'nombre_grupo');

            // 3?? Índice para rendimiento
            $table->index('competicion_id');
        });
    }

    public function down()
    {
        Schema::table('grupos', function (Blueprint $table) {

            // Revertir cambios
            $table->dropIndex(['competicion_id']);
            $table->dropColumn('competicion_id');

            $table->renameColumn('nombre_grupo', 'nombre');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->string('nombre_equipo')->nullable();
            $table->string('nit')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono_equipo')->nullable();
            $table->string('email_equipo')->nullable();
            $table->integer('valor_inscripcion')->nullable();
            $table->string('nombre_dt')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->dropColumn([
                'nombre_equipo',
                'nit',
                'direccion',
                'telefono_equipo',
                'email_equipo',
                'valor_inscripcion',
                'nombre_dt',
            ]);
        });
    }
};

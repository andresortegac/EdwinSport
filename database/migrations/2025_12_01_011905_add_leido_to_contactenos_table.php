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
    Schema::table('contactenos', function (Blueprint $table) {
        $table->boolean('leido')->default(false);
    });
}

public function down()
{
    Schema::table('contactenos', function (Blueprint $table) {
        $table->dropColumn('leido');
    });
}

};

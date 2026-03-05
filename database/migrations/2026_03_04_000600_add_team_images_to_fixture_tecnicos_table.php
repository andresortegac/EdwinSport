<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fixture_tecnicos', function (Blueprint $table) {
            $table->string('local_image_path', 2048)->nullable()->after('image_path');
            $table->string('visitante_image_path', 2048)->nullable()->after('local_image_path');
        });
    }

    public function down(): void
    {
        Schema::table('fixture_tecnicos', function (Blueprint $table) {
            $table->dropColumn(['local_image_path', 'visitante_image_path']);
        });
    }
};

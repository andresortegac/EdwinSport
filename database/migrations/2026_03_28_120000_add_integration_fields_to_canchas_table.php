<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('canchas', function (Blueprint $table) {
            $table->string('ciudad')->nullable()->after('ubicacion');
            $table->string('subdominio')->nullable()->after('ciudad');
            $table->string('integration_identifier')->nullable()->unique()->after('subdominio');
            $table->string('api_base_url')->nullable()->after('integration_identifier');
            $table->string('integration_token')->nullable()->after('api_base_url');
        });
    }

    public function down(): void
    {
        Schema::table('canchas', function (Blueprint $table) {
            $table->dropUnique(['integration_identifier']);
            $table->dropColumn([
                'ciudad',
                'subdominio',
                'integration_identifier',
                'api_base_url',
                'integration_token',
            ]);
        });
    }
};

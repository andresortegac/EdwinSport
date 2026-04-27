<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('store_items', function (Blueprint $table) {
            $table->string('company_logo_path')->nullable()->after('company_website');
            $table->string('company_logo_url')->nullable()->after('company_logo_path');
            $table->text('catalog_summary')->nullable()->after('company_logo_url');
            $table->json('catalog_images')->nullable()->after('catalog_summary');
        });
    }

    public function down(): void
    {
        Schema::table('store_items', function (Blueprint $table) {
            $table->dropColumn([
                'company_logo_path',
                'company_logo_url',
                'catalog_summary',
                'catalog_images',
            ]);
        });
    }
};

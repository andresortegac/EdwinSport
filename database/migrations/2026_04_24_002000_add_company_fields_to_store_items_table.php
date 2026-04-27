<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('store_items', function (Blueprint $table) {
            $table->string('company_name')->nullable()->after('image_url');
            $table->string('company_phone')->nullable()->after('company_name');
            $table->string('company_email')->nullable()->after('company_phone');
            $table->string('company_location')->nullable()->after('company_email');
            $table->string('company_website')->nullable()->after('company_location');
        });
    }

    public function down(): void
    {
        Schema::table('store_items', function (Blueprint $table) {
            $table->dropColumn([
                'company_name',
                'company_phone',
                'company_email',
                'company_location',
                'company_website',
            ]);
        });
    }
};


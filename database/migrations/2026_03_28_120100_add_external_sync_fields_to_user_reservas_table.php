<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_reservas', function (Blueprint $table) {
            $table->string('estado_solicitud')->default('pendiente')->after('numero_subcancha');
            $table->string('external_reference')->nullable()->after('estado_solicitud');
            $table->string('external_sync_status')->default('pendiente_envio')->after('external_reference');
            $table->text('external_sync_message')->nullable()->after('external_sync_status');
            $table->timestamp('external_sent_at')->nullable()->after('external_sync_message');
        });
    }

    public function down(): void
    {
        Schema::table('user_reservas', function (Blueprint $table) {
            $table->dropColumn([
                'estado_solicitud',
                'external_reference',
                'external_sync_status',
                'external_sync_message',
                'external_sent_at',
            ]);
        });
    }
};

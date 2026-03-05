<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fixture_streams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('grupo_id')->constrained('grupos')->cascadeOnDelete();
            $table->unsignedInteger('jornada');
            $table->unsignedInteger('partido_numero');
            $table->string('live_url', 2048);
            $table->string('platform', 40);
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(
                ['event_id', 'grupo_id', 'jornada', 'partido_numero'],
                'fixture_streams_event_group_round_match_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fixture_streams');
    }
};

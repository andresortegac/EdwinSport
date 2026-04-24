<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fixture_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('grupo_id')->constrained('grupos')->cascadeOnDelete();
            $table->unsignedInteger('jornada');
            $table->unsignedInteger('partido_numero');

            $table->unsignedTinyInteger('score_local')->nullable();
            $table->unsignedTinyInteger('score_visitante')->nullable();

            $table->json('local_lineup')->nullable();
            $table->json('visitante_lineup')->nullable();

            $table->json('local_yellow_cards')->nullable();
            $table->json('local_red_cards')->nullable();
            $table->json('local_blue_cards')->nullable();

            $table->json('visitante_yellow_cards')->nullable();
            $table->json('visitante_red_cards')->nullable();
            $table->json('visitante_blue_cards')->nullable();

            $table->string('local_top_scorer', 120)->nullable();
            $table->unsignedTinyInteger('local_top_scorer_goals')->nullable();
            $table->string('visitante_top_scorer', 120)->nullable();
            $table->unsignedTinyInteger('visitante_top_scorer_goals')->nullable();

            $table->string('local_best_goalkeeper', 120)->nullable();
            $table->unsignedTinyInteger('local_goalkeeper_goals_conceded')->nullable();
            $table->string('visitante_best_goalkeeper', 120)->nullable();
            $table->unsignedTinyInteger('visitante_goalkeeper_goals_conceded')->nullable();

            $table->text('highlights')->nullable();

            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(
                ['event_id', 'grupo_id', 'jornada', 'partido_numero'],
                'fixture_reports_event_group_round_match_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fixture_reports');
    }
};


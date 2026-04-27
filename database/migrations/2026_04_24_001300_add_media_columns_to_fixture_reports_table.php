<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $addMediaImages = !Schema::hasColumn('fixture_reports', 'media_images');
        $addMediaVideos = !Schema::hasColumn('fixture_reports', 'media_videos');

        if (!$addMediaImages && !$addMediaVideos) {
            return;
        }

        Schema::table('fixture_reports', function (Blueprint $table) use ($addMediaImages, $addMediaVideos) {
            if ($addMediaImages) {
                $table->json('media_images')->nullable()->after('highlights');
            }

            if ($addMediaVideos) {
                $table->json('media_videos')->nullable()->after('media_images');
            }
        });
    }

    public function down(): void
    {
        $dropMediaImages = Schema::hasColumn('fixture_reports', 'media_images');
        $dropMediaVideos = Schema::hasColumn('fixture_reports', 'media_videos');

        if (!$dropMediaImages && !$dropMediaVideos) {
            return;
        }

        Schema::table('fixture_reports', function (Blueprint $table) use ($dropMediaImages, $dropMediaVideos) {
            if ($dropMediaVideos) {
                $table->dropColumn('media_videos');
            }

            if ($dropMediaImages) {
                $table->dropColumn('media_images');
            }
        });
    }
};

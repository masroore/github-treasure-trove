<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UpgradeToMedialibrary8 extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('media', function (Blueprint $table): void {
            $table->string('conversions_disk')->nullable();
            $table->uuid('uuid')->nullable();
        });

        DB::raw("UPDATE media SET 'conversions_disk' = 'disk';");

        Media::cursor()->each(
            function (Media $media) {
                return $media->update(['uuid' => Str::uuid()]);
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
}

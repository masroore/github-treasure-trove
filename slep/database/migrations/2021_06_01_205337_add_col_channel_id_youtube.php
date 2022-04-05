<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColChannelIdYoutube extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('youtube_videos', function (Blueprint $table): void {
            $table->string('id_channel')->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
}

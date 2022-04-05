<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColTagsResults extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tweets', function (Blueprint $table): void {
            $table->string('tags')->default('');
        });
        Schema::table('youtube_videos', function (Blueprint $table): void {
            $table->string('tags')->default('');
        });
        Schema::table('google_news_articles', function (Blueprint $table): void {
            $table->string('tags')->default('');
        });
        Schema::table('facebook_posts', function (Blueprint $table): void {
            $table->string('tags')->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
}

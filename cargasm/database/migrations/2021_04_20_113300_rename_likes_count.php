<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameLikesCount extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            $table->renameColumn('likes_count', 'likeable_count');
        });

        Schema::table('events', function (Blueprint $table): void {
            $table->renameColumn('likes_count', 'likeable_count');
        });
        Schema::table('photos', function (Blueprint $table): void {
            $table->renameColumn('likes_count', 'likeable_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            $table->renameColumn('likeable_count', 'likes_count');
        });
        Schema::table('events', function (Blueprint $table): void {
            $table->renameColumn('likeable_count', 'likes_count');
        });
        Schema::table('photos', function (Blueprint $table): void {
            $table->renameColumn('likeable_count', 'likes_count');
        });
    }
}

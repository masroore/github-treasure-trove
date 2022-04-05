<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLikesCount extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            $table->string('likes_count')->nullable();
        });

        Schema::table('events', function (Blueprint $table): void {
            $table->string('likes_count')->nullable();
        });
        Schema::table('photos', function (Blueprint $table): void {
            $table->string('likes_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            $table->dropColumn('likes_count');
        });
        Schema::table('events', function (Blueprint $table): void {
            $table->dropColumn('likes_count');
        });
        Schema::table('photos', function (Blueprint $table): void {
            $table->dropColumn('likes_count');
        });
    }
}

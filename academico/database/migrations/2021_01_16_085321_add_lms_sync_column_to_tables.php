<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLmsSyncColumnToTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table): void {
            $table->boolean('sync_to_lms')->nullable();
            $table->bigInteger('lms_id')->nullable();
        });

        Schema::table('rhythms', function (Blueprint $table): void {
            $table->bigInteger('lms_id')->nullable();
        });

        Schema::table('levels', function (Blueprint $table): void {
            $table->bigInteger('lms_id')->nullable();
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->bigInteger('lms_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
}

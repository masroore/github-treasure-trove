<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStudentsCountOverride extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table): void {
            $table->integer('head_count')
                ->after('spots')
                ->nullable();

            $table->integer('new_students')
                ->after('head_count')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table): void {
            $table->dropColumn('head_count');
        });

        Schema::table('courses', function (Blueprint $table): void {
            $table->dropColumn('new_students');
        });
    }
}

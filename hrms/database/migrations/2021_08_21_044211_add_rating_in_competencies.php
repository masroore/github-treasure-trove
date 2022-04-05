<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRatingInCompetencies extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(
            'indicators',
            function (Blueprint $table): void {
                $table->string('rating')->nullable()->after('designation');
            }
        );

        Schema::table(
            'appraisals',
            function (Blueprint $table): void {
                $table->string('rating')->nullable()->after('employee');
            }
        );
        Schema::table(
            'goal_trackings',
            function (Blueprint $table): void {
                $table->string('rating')->nullable()->after('subject');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'indicators',
            function (Blueprint $table): void {
                $table->dropColumn('rating');
            }
        );
        Schema::table(
            'appraisals',
            function (Blueprint $table): void {
                $table->dropColumn('rating');
            }
        );
        Schema::table(
            'goal_trackings',
            function (Blueprint $table): void {
                $table->dropColumn('rating');
            }
        );
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddYearCarsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table): void {
            $table->dropColumn('is_active');
            $table->dropColumn('year_end');
            $table->dropColumn('year_begin');
            $table->dropColumn('generation_name');
            $table->dropColumn('name_en');
            $table->dropColumn('name');
            $table->dropColumn('status');

            $table->integer('year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table): void {
            $table->dropColumn('year');
        });
    }
}

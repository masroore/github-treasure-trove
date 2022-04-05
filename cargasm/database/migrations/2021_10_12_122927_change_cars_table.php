<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCarsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table): void {
            $table->dropColumn('title');
            $table->dropColumn('year');

            $table->string('name')->nullable();
            $table->string('name_en')->nullable();
            $table->string('generation_name')->nullable();
            $table->string('year_begin')->nullable();
            $table->string('year_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table): void {
            $table->string('title');

            $table->dropColumn('name');
            $table->dropColumn('name_en');
            $table->dropColumn('generation_name');
            $table->dropColumn('year_begin');
            $table->dropColumn('year_end');
        });
    }
}

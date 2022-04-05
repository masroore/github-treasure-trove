<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEyepiece extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('eyepieces', function (Blueprint $table): void {
            // Create new columns for the brand and the type of eyepiece
            $table->string('brand')->after('name')->default('');
            $table->string('type')->after('focalLength')->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eyepieces', function (Blueprint $table): void {
            $table->dropColumn('brand');
            $table->dropColumn('type');
        });
    }
}

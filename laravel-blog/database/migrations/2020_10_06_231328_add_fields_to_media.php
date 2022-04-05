<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToMedia extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('media', function (Blueprint $table): void {
            $table->uuid('uuid')->nullable();
            $table->string('conversions_disk')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media', function (Blueprint $table): void {
            $table->dropColumn('uuid');
            $table->dropColumn('conversions_disk');
        });
    }
}

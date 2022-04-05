<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EnlargeSettingsColumns extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //make value, default columns bigger
        Schema::table('ticketit_settings', function (Blueprint $table): void {
            $table->mediumText('value')->change();
            $table->mediumText('default')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticketit_settings', function (Blueprint $table): void {
            $table->string('value')->change();
            $table->string('default')->change();
        });
    }
}

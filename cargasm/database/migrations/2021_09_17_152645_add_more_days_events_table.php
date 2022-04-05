<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreDaysEventsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table): void {
            $table->boolean('more_days')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table): void {
            $table->dropColumn('more_days');
        });
    }
}

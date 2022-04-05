<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumns extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('vender_categories');

        Schema::table('multi_currencies', function (Blueprint $table): void {
            $table->dropColumn('row_id');
            $table->dropColumn('rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
}

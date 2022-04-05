<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusHandbooksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('handbooks', function (Blueprint $table): void {
            $table->string('status')->nullable();
            $table->integer('car_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('handbooks', function (Blueprint $table): void {
            $table->dropColumn('status');
            $table->dropColumn('car_id');
        });
    }
}

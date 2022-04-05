<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCashOnDeliveryColumnToStoresTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table): void {
            $table->dropColumn('disount_type');
        });

        Schema::table('stores', function (Blueprint $table): void {
            $table->enum('cash_on_delivery', ['enable', 'disable'])->default('enable')->after('status');
            $table->enum('disount_type', ['flat', 'percentage'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table): void {
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeRegionToStateToRelatedTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('customer_addresses', function (Blueprint $table): void {
            $table->dropColumn('country');
            $table->dropColumn('region_id');
        });

        Schema::table('customer_addresses', function (Blueprint $table): void {
            $table->unsignedBigInteger('country')->default(null)->nullable();
            $table->string('state')->default(null)->nullable();
        });

        Schema::table('orders', function (Blueprint $table): void {
            $table->dropColumn('payment_region');
            $table->dropColumn('shipping_region');
        });

        Schema::table('orders', function (Blueprint $table): void {
            $table->string('payment_state')->default(null)->nullable();
            $table->string('shipping_state')->default(null)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('state_to_related', function (Blueprint $table): void {
        });
    }
}

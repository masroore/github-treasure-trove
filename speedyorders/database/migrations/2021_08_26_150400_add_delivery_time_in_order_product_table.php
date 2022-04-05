<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryTimeInOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_products', function (Blueprint $table): void {
            if (!Schema::hasColumn('order_products', 'shipping_delivery_times_id')) {
                $table->integer('shipping_delivery_times_id')->default(null)->nullable()->after('tax');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_products', function (Blueprint $table): void {
        });
    }
}

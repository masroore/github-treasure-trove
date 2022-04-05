<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInProductDeliveryTimes extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_deliverytime', function (Blueprint $table): void {
            if (!Schema::hasColumn('product_deliverytime', 'shipping_zone_groups_id')) {
                $table->integer('shipping_zone_groups_id')->default(null)->nullable()->after('shipping_delivery_times_id');
            }
            if (!Schema::hasColumn('product_deliverytime', 'shipping_packages_id')) {
                $table->integer('shipping_packages_id')->default(null)->nullable()->after('shipping_zone_groups_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_deliverytime', function (Blueprint $table): void {
        });
    }
}

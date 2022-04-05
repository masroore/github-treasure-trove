<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInOrders extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            if (!Schema::hasColumn('orders', 'payment_region')) {
                $table->string('payment_region')->default(null)->nullable()->after('payment_city');
            }
            if (!Schema::hasColumn('orders', 'shipping_region')) {
                $table->string('shipping_region')->default(null)->nullable()->after('shipping_city');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
        });
    }
}

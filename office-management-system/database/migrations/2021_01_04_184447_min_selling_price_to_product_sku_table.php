<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MinSellingPriceToProductSkuTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_sku', function (Blueprint $table): void {
            $table->integer('min_selling_price')->default(0)->after('selling_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_sku', function (Blueprint $table): void {
            $table->dropColumn('min_selling_price');
        });
    }
}

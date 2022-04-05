<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostOfGoodsHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cost_of_goods_histories', function (Blueprint $table): void {
            $table->id();
            $table->string('costable_type')->nullable();
            $table->unsignedBigInteger('costable_id')->nullable();
            $table->string('storeable_type')->nullable();
            $table->unsignedBigInteger('storeable_id')->nullable();
            $table->date('date')->nullable();
            $table->unsignedInteger('product_sku_id')->nullable();
            $table->Integer('previous_remaining_stock')->nullable();
            $table->Integer('newly_stock')->nullable();
            $table->double('previous_cost_of_goods_sold', 16, 2)->default(0);
            $table->double('new_cost_of_goods_sold', 16, 2)->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_of_goods_histories');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimateProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estimate_products', function (Blueprint $table): void {
            $table->id();
            $table->timestamps();
            $table->integer('estimateId');
            $table->integer('quanity')->default(1);
            $table->integer('productId');
            $table->integer('discount')->default(0);
            $table->integer('discountType');
            $table->decimal('listPrice', 6, 2);
            $table->decimal('chargedPrice', 7, 2);
            $table->boolean('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimate_products');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariationItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_variation_items', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->bigInteger('attribute_id')->unsigned()->index('p_variation_items_attribute_id_index')->comment('Belongs to product_attributes table');
            $table->bigInteger('variation_id')->unsigned()->index('p_variation_items_variation_id_index')->comment('Belongs to product_variations table');
            $table->foreign('attribute_id')
                ->references('id')
                ->on('product_attributes')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('variation_id')
                ->references('id')
                ->on('product_variations')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variation_items');
        Schema::table('product_variation_items', function (Blueprint $table): void {
            $table->dropSoftDeletes();
        });
    }
}

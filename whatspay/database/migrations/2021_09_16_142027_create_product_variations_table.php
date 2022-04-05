<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_variations', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->unsigned()->index('p_attr_product_id_index');
            $table->bigInteger('configurable_product_id')->unsigned()->comment('Belongs to products table of a parent product')->index('p_attr_configurable_product_id_index');
            $table->tinyInteger('is_default')->default(0);
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('configurable_product_id')
                ->references('id')
                ->on('products')
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
        Schema::dropIfExists('product_variations');
        Schema::table('product_variations', function (Blueprint $table): void {
            $table->dropSoftDeletes();
        });
    }
}

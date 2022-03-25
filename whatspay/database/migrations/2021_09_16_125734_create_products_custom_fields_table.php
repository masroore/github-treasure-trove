<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_custom_fields', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned()->index('cf_product_id_index');
            $table->string('label', 100)->nullable();
            $table->string('value', 255)->nullable();
            $table->foreign('product_id')
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_custom_fields');
        Schema::table('products_custom_fields', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}

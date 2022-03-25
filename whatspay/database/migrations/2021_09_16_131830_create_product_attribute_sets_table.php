<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributeSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attribute_sets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('store_id')->unsigned()->index('p_attr_sets_store_id_index');
            $table->string('title', 120)->nullable();
            $table->string('slug', 120)->unique()->nullable();
            $table->enum('display_layout', ['dropdown', 'visual', 'text'])->default('dropdown')->comment('dropdown: Dropdown Swatch, visual: Visual Swatch, text: Text Swatch')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0: Inactive, 1: Active');
            $table->tinyInteger('order')->default(0);
            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
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
        Schema::dropIfExists('product_attribute_sets');
        Schema::table('product_attribute_sets', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}

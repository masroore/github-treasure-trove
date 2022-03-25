<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('attribute_set_id')->unsigned()->index('p_attr_attribute_set_id_index');
            $table->string('title', 120)->nullable();
            $table->string('slug', 120)->nullable();
            $table->string('color', 50)->nullable();
            $table->string('image', 191)->nullable();
            $table->tinyInteger('is_default')->default(0);
            $table->tinyInteger('order')->default(0);
            $table->tinyInteger('status')->default(1)->comment('0: Inactive, 1: Active')->index('p_attr_status_index');
            $table->foreign('attribute_set_id')
                ->references('id')
                ->on('product_attribute_sets')
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
        Schema::dropIfExists('product_attributes');
        Schema::table('product_attributes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}

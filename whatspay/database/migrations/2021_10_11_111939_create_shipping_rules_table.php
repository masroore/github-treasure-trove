<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shipping_id')->unsigned()->index('shipping_rules_shipping_id_index')->comment('Belongs to shipping table');
            $table->string('name', 120)->nullable();
            $table->enum('price_type', ['flat', 'percentage'])->default('flat');
            $table->float('from', 15, 2)->nullable();
            $table->float('to', 15, 2)->nullable();
            $table->float('price', 15, 2)->nullable();
            $table->foreign('shipping_id')
                ->references('id')
                ->on('shippings')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_rules');
    }
}

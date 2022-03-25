<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('store_id')->unsigned()->index('shipping_companies_store_id_index')->comment('Belongs to stores table');
            $table->string('image', '255')->nullable();
            $table->string('shipping_service', '100')->nullable();
            $table->string('company_url', '255')->nullable();
            $table->string('tracking_url', '255')->nullable();
            $table->string('address', '255')->nullable();
            $table->string('country', '60')->nullable();
            $table->string('state', '16')->nullable();
            $table->string('city', '50')->nullable();
            $table->string('postal_code', '14')->nullable();
            $table->string('email', '100')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_featured')->default(0);
            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
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
        Schema::dropIfExists('shipping_companies');
    }
}

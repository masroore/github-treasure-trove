<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_addresses', function (Blueprint $table): void {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('customer_id')->default(null)->nullable();
            $table->string('c_first_name')->default(null)->nullable();
            $table->string('c_last_name')->default(null)->nullable();
            $table->text('address_1')->default(null)->nullable();
            $table->text('address_2')->default(null)->nullable();
            $table->string('c_telephone')->default(null)->nullable();
            $table->string('city')->default(null)->nullable();
            $table->integer('postcode')->default(null)->nullable();
            $table->string('country')->default(null)->nullable();
            $table->integer('region_id')->default(null)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('stores')) {
            Schema::create('stores', function (Blueprint $table): void {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->nullable();
                $table->string('name', 191)->nullable();
                $table->text('address', 65535)->nullable();
                $table->string('phone', 191)->nullable();
                $table->string('mobile', 191)->nullable();
                $table->string('email', 191);
                $table->integer('city_id')->unsigned()->nullable();
                $table->integer('country_id')->unsigned()->nullable();
                $table->integer('state_id')->unsigned()->nullable();
                $table->string('pin_code', 191)->nullable();
                $table->enum('status', ['0', '1'])->default('0');
                $table->enum('verified_store', ['0', '1'])->default('0');
                $table->string('website', 191)->nullable();
                $table->string('store_logo', 191)->nullable();
                $table->string('branch', 191)->nullable();
                $table->string('ifsc', 100)->nullable();
                $table->string('account', 191)->nullable();
                $table->string('bank_name', 191)->nullable();
                $table->string('account_name', 191)->nullable();
                $table->string('paypal_email', 191)->nullable();
                $table->bigInteger('paytem_mobile')->nullable();
                $table->string('preferd', 50)->nullable();
                $table->timestamps();
                $table->enum('apply_vender', ['0', '1'])->nullable()->default('0');
                $table->enum('rd', ['0', '1'])->nullable()->default('0');
                $table->enum('featured', ['0', '1'])->nullable()->default('0');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('stores');
    }
}

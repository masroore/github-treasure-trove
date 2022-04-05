<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('configs')) {
            Schema::create('configs', function (Blueprint $table): void {
                $table->increments('id');
                $table->boolean('payu_enable')->nullable();
                $table->boolean('instamojo_enable')->nullable();
                $table->boolean('stripe_enable')->nullable();
                $table->boolean('paypal_enable')->nullable();
                $table->boolean('fb_login_enable')->nullable();
                $table->boolean('google_login_enable')->nullable();
                $table->integer('pincode_system')->default(0);
                $table->timestamps();
                $table->integer('paytm_enable')->unsigned()->default(0);
                $table->integer('razorpay')->unsigned()->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('configs');
    }
}

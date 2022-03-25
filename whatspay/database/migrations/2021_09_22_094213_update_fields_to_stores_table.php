<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFieldsToStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('acc_holder_mobile_number', 16)->nullable();
            $table->string('acc_holder_name', 100)->nullable();
            $table->string('paypal_email', 150)->nullable();
            $table->string('bank_name', 150)->nullable();
            $table->string('passport_number', 15)->nullable();
            $table->string('swift_code', 15)->nullable();
            $table->enum('cash_on_delivery', ['enable', 'disable']);
            $table->integer('store_service_charges')->default(0);
            $table->enum('service_charges', ['include', 'exclude']);
            $table->char('currency', 3)->nullable();
            $table->enum('shipping_percentage_type', ['flat', 'percentage']);
            $table->integer('shipping_percentage')->default(0);
            $table->integer('applicable_range')->default(0);
            $table->integer('delivery_hours')->default(0);
            $table->integer('delivery_minutes')->default(0);
            // $table->integer('delivery_days')->default(0);
            // $table->string('working_days',73)->nullable();
            $table->enum('delivery_rangeIndex', ['area', 'city', 'country', 'international']);
            $table->float('delivery_radius', 8, 2)->nullable();
            // $table->string('opening_time',5)->nullable();
            // $table->string('closing_time',5)->nullable();
            $table->enum('disount_type', ['flat', 'specific']);
            $table->integer('discount_amount')->default(0);
            $table->string('service_option', 50)->nullable();
            // $table->date('free_trial_start_date');
            $table->date('free_trial_start_date')->default(date('Y-m-d'));
            // $table->timestamp("free_trial_start_date");
            $table->string('qrcode_img', 255)->nullable();
            $table->enum('auto_subscription', ['off', 'on']);
            $table->tinyInteger('subscription_canceled_status')->default(0);
            // $table->date('subscription_canceled_date');
            $table->date('subscription_canceled_date')->default(date('Y-m-d'));
            // $table->timestamp("subscription_canceled_date");
            // $table->date('subscription_restart_date');
            // $table->timestamp("subscription_restart_date");
            $table->date('subscription_restart_date')->default(date('Y-m-d'));
            $table->enum('orders_accept_status', ['no', 'yes'])->comment('accept orders in closing hours, no: not accepting orders in closing hours');
            $table->tinyInteger('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {

        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreteOrderHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('order_id')->default(null)->nullable();
            $table->text('comment')->nullable()->default(null);
            $table->string('status')->default('initiated')->comment('initiated', 'processing', 'pending', 'processed', 'completed', 'delivered', 'denied', 'expired', 'expired', 'failed', 'refunded', 'reversed', 'shipped', 'missing_orders', 'cancelled', 'cancelled_reversal', 'completed', 'chargeback', 'voided');
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
        Schema::dropIfExists('order_histories');
    }
}

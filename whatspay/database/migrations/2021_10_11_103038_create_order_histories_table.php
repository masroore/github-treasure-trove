<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_histories', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->enum('action', ['create_order_from_payment_page', 'create_order', 'cancel_order', 'confirm_order', 'create_shipment', 'update_status', 'refund', 'cancel_shipment', 'confirm_payment', 'create_order_from_seeder', 'create_from_order', 'update_cod_status', 'shipping_update_status'])->default('create_order');
            $table->string('description', 255)->nullable();
            $table->bigInteger('user_id')->unsigned()->index('order_histories_user_id_index')->comment('Belongs to id of users table PK. 0(zero) means changed by supper admin');
            $table->bigInteger('order_id')->unsigned()->index('order_histories_order_id_index')->comment('Belongs to orders table');
            $table->text('extras')->nullable()->comment('{"amount":"50.65","method":"cod"}');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_histories');
    }
}

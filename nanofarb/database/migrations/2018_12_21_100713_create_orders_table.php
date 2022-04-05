<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('number')->nullable();
            $table->string('status');
            $table->string('payment_status')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->json('data')->nullable(); // info about sales, discount,...
            $table->text('comment')->nullable();
            $table->tinyInteger('type')->default(1); // 1 - order, 2 - cart, ...
            $table->ipAddress('ip')->nullable();
            $table->timestamps();
            $table->timestamp('ordered_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}

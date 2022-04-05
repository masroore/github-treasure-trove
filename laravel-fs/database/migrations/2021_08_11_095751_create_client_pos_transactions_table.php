<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientPosTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client_pos_transactions', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('coin_transactions_id');
            $table->unsignedBigInteger('client_pos_id');

            $table->unsignedBigInteger('user_id');
            $table->timestamp('register_date')->nullable();
            $table->string('ip', 20);

            $table->foreign('coin_transactions_id')->references('id')->on('coin_transactions');
            $table->foreign('client_pos_id')->references('id')->on('client_pos');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_pos_transactions');
    }
}

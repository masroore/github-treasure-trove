<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coin_transactions', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('type_coin_id');
            $table->unsignedBigInteger('type_transactions_id');
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('user_id');
            $table->timestamp('date_register')->nullable();
            $table->string('ip', 20);

            $table->foreign('type_coin_id')->references('id')->on('type_coins');
            $table->foreign('type_transactions_id')->references('id')->on('type_transactions');
            $table->foreign('user_id')->references('id')->on('users');
        });
        DB::table('coin_transactions')->insert([
            'type_coin_id' => 1,
            'type_transactions_id' => 1,
            'status' => 1,
            'user_id' => 1,
            'date_register' => now(),
            'ip' => \Request::ip(),
        ]);
        DB::table('coin_transactions')->insert([
            'type_coin_id' => 2,
            'type_transactions_id' => 2,
            'status' => 1,
            'user_id' => 1,
            'date_register' => now(),
            'ip' => \Request::ip(),
        ]);
        DB::table('coin_transactions')->insert([
            'type_coin_id' => 1,
            'type_transactions_id' => 3,
            'status' => 1,
            'user_id' => 1,
            'date_register' => now(),
            'ip' => \Request::ip(),
        ]);
        DB::table('coin_transactions')->insert([
            'type_coin_id' => 1,
            'type_transactions_id' => 4,
            'status' => 1,
            'user_id' => 1,
            'date_register' => now(),
            'ip' => \Request::ip(),
        ]);
        DB::table('coin_transactions')->insert([
            'type_coin_id' => 1,
            'type_transactions_id' => 5,
            'status' => 1,
            'user_id' => 1,
            'date_register' => now(),
            'ip' => \Request::ip(),
        ]);
        DB::table('coin_transactions')->insert([
            'type_coin_id' => 1,
            'type_transactions_id' => 6,
            'status' => 1,
            'user_id' => 1,
            'date_register' => now(),
            'ip' => \Request::ip(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_transactions');
    }
}

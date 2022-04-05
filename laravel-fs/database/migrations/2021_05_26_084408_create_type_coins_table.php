<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeCoinsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('type_coins', function (Blueprint $table): void {
            $table->id();
            $table->string('symbol', 5);
            $table->string('name_coin', 50);
            $table->boolean('status')->default(true);

            $table->unsignedBigInteger('user_id');
            $table->timestamp('register_date')->nullable();
            $table->string('ip', 20);

            $table->foreign('user_id')->references('id')->on('users');
        });
        DB::table('type_coins')->insert([
            [
                'symbol' => 'VEB',
                'name_coin' => 'Venezuela Bolivar',
                'status' => 1,
                'user_id' => 1,
                'register_date' => '2021-06-26 14:00:00',
                'ip' => '192.168.2.5',
            ],
            [
                'symbol' => 'USD',
                'name_coin' => 'E.E.U.U Dolar',
                'status' => 1,
                'user_id' => 1,
                'register_date' => '2021-06-26 14:00:00',
                'ip' => '192.168.2.5',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_coins');
    }
}

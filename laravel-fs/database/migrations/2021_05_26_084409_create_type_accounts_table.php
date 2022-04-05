<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeAccountsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('type_accounts', function (Blueprint $table): void {
            $table->id();
            $table->string('name_product', 150);
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('type_coin_id');
            $table->unsignedBigInteger('bank_id');

            $table->unsignedBigInteger('user_id');
            $table->timestamp('register_date')->nullable();
            $table->string('ip', 20);

            $table->foreign('type_coin_id')->references('id')->on('type_coins');
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->foreign('user_id')->references('id')->on('users');
        });
        DB::table('type_accounts')->insert([
            [
                'name_product' => 'Cuenta Amiga',
                'status' => 1,
                'type_coin_id' => 1,
                'bank_id' => 1,
                'user_id' => 1,
                'register_date' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_product' => 'Cuenta Cash',
                'status' => 1,
                'type_coin_id' => 2,
                'bank_id' => 1,
                'user_id' => 1,
                'register_date' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'name_product' => 'Cuenta Moneda Extranjera USD',
                'status' => 1,
                'type_coin_id' => 2,
                'bank_id' => 1,
                'user_id' => 1,
                'register_date' => now(),
                'ip' => \Request::ip(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_accounts');
    }
}

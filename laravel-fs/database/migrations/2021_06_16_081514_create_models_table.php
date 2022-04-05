<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('models', function (Blueprint $table): void {
            $table->id();
            $table->string('serial', 15);
            $table->string('weight', 100);
            $table->string('color', 100);
            $table->string('quantity');
            $table->string('price');
            $table->boolean('status')->default(true);

            $table->unsignedBigInteger('trade_mark_id');

            $table->unsignedBigInteger('user_id');
            $table->timestamp('date_register')->nullable();
            $table->string('ip', 20);

            $table->foreign('trade_mark_id')->references('id')->on('trade_marks');
            $table->foreign('user_id')->references('id')->on('users');
        });
        DB::table('models')->insert([
            [
                'serial' => '3000',
                'weight' => '5,1 Kg',
                'color' => 'SilverGrey',
                'quantity' => '10',
                'price' => '200,00',
                'status' => 1,
                'trade_mark_id' => 1,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'serial' => '7000',
                'weight' => '9,7 Kg',
                'color' => 'SilverGrey',
                'quantity' => '10',
                'price' => '200,00',
                'status' => 1,
                'trade_mark_id' => 1,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'serial' => '8000',
                'weight' => '7,1 Kg',
                'color' => 'SilverGrey',
                'quantity' => '10',
                'price' => '200,00',
                'status' => 1,
                'trade_mark_id' => 1,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],
            [
                'serial' => '9000',
                'weight' => '7,1 Kg',
                'color' => 'SilverGrey',
                'quantity' => '10',
                'price' => '200,00',
                'status' => 1,
                'trade_mark_id' => 1,
                'user_id' => 1,
                'date_register' => now(),
                'ip' => \Request::ip(),
            ],

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('models');
    }
}

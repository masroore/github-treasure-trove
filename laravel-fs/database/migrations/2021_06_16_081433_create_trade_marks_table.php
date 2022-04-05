<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradeMarksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trade_marks', function (Blueprint $table): void {
            $table->id();
            $table->string('name_trade_mark', 200);
            $table->boolean('status')->default(true);

            $table->unsignedBigInteger('user_id');
            $table->timestamp('date_register')->nullable();
            $table->string('ip', 20);

            $table->foreign('user_id')->references('id')->on('users');
        });
        DB::table('trade_marks')->insert([
            [
                'name_trade_mark' => 'AMP',
                'status' => 1,
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
        Schema::dropIfExists('trade_marks');
    }
}

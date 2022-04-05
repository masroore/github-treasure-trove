<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('password_histories', function (Blueprint $table): void {
            $table->id();
            $table->string('password', 60);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();

            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users');
        });
        DB::table('password_histories')->insert([
            [
                'password' => Hash::make('Puropago.1'),
                'start_date' => now(),
                'end_date' => now(),
                'user_id' => 1,
            ],
            [
                'password' => Hash::make('Puropago.1'),
                'start_date' => now(),
                'end_date' => now(),
                'user_id' => 2,
            ],
            [
                'password' => Hash::make('Puropago.1'),
                'start_date' => now(),
                'end_date' => now(),
                'user_id' => 3,
            ],
            [
                'password' => Hash::make('Puropago.1'),
                'start_date' => now(),
                'end_date' => now(),
                'user_id' => 4,
            ],
            [
                'password' => Hash::make('Puropago.1'),
                'start_date' => now(),
                'end_date' => now(),
                'user_id' => 5,
            ],
            [
                'password' => Hash::make('Puropago.1'),
                'start_date' => now(),
                'end_date' => now(),
                'user_id' => 6,
            ],
            [
                'password' => Hash::make('Puropago.1'),
                'start_date' => now(),
                'end_date' => now(),
                'user_id' => 7,
            ],
            [
                'password' => Hash::make('Puropago.1'),
                'start_date' => now(),
                'end_date' => now(),
                'user_id' => 8,
            ],

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_histories');
    }
}

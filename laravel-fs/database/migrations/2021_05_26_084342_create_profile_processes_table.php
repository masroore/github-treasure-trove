<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileProcessesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profile_processes', function (Blueprint $table): void {
            $table->id();
            $table->timestamp('date_register')->nullable();

            $table->unsignedBigInteger('process_id');
            $table->unsignedBigInteger('profile_id');

            $table->foreign('process_id')->references('id')->on('processes');
            $table->foreign('profile_id')->references('id')->on('profiles');
        });
        DB::table('profile_processes')->insert([
            /*
          |--------------------------------------------------------------------------
          | PERMISSION TO ADMIN SISTEM
          |--------------------------------------------------------------------------
         */
            [
                'date_register' => now(),
                'process_id' => 1,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 1,
                'profile_id' => 2,
            ],
            [
                'date_register' => now(),
                'process_id' => 2,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 2,
                'profile_id' => 2,
            ],
            [
                'date_register' => now(),
                'process_id' => 3,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 3,
                'profile_id' => 2,
            ],
            [
                'date_register' => now(),
                'process_id' => 4,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 4,
                'profile_id' => 2,
            ],
            [
                'date_register' => now(),
                'process_id' => 5,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 5,
                'profile_id' => 2,
            ],
            [
                'date_register' => now(),
                'process_id' => 6,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 6,
                'profile_id' => 2,
            ],
            [
                'date_register' => now(),
                'process_id' => 7,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 7,
                'profile_id' => 2,
            ],
            /*
          |--------------------------------------------------------------------------
          | PERMISSION TO MAINTENANCE
          |--------------------------------------------------------------------------
         */
            [
                'date_register' => now(),
                'process_id' => 8,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 9,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 10,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 11,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 12,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 13,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 14,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 15,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 16,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 17,
                'profile_id' => 1,
            ],
            /*
          |--------------------------------------------------------------------------
          | PERMISSION TO ADQUIRENCE
          |--------------------------------------------------------------------------
         */
            [
                'date_register' => now(),
                'process_id' => 18,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 19,
                'profile_id' => 1,
            ],
            /*
          |--------------------------------------------------------------------------
          | PERMISSION TO POS
          |--------------------------------------------------------------------------
         */
            [
                'date_register' => now(),
                'process_id' => 20,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 20,
                'profile_id' => 3,
            ],
            [
                'date_register' => now(),
                'process_id' => 21,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 22,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 22,
                'profile_id' => 4,
            ],
            [
                'date_register' => now(),
                'process_id' => 23,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 23,
                'profile_id' => 3,
            ],

            [
                'date_register' => now(),
                'process_id' => 24,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 24,
                'profile_id' => 4,
            ],

            [
                'date_register' => now(),
                'process_id' => 25,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 25,
                'profile_id' => 4,
            ],
            [
                'date_register' => now(),
                'process_id' => 26,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 26,
                'profile_id' => 4,
            ],

            /*
          |--------------------------------------------------------------------------
          |PERMISSION TO CLIENTS
          |--------------------------------------------------------------------------
         */
            [
                'date_register' => now(),
                'process_id' => 27,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 28,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 29,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 30,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 31,
                'profile_id' => 1,
            ],
            /*
          |--------------------------------------------------------------------------
          |PERMISSION TO CONSULT
          |--------------------------------------------------------------------------
         */
            [
                'date_register' => now(),
                'process_id' => 32,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 32,
                'profile_id' => 3,
            ],
            [
                'date_register' => now(),
                'process_id' => 32,
                'profile_id' => 4,
            ],
            [
                'date_register' => now(),
                'process_id' => 33,
                'profile_id' => 1,
            ],
            [
                'date_register' => now(),
                'process_id' => 33,
                'profile_id' => 3,
            ],
            [
                'date_register' => now(),
                'process_id' => 33,
                'profile_id' => 4,
            ],
            [
                'date_register' => now(),
                'process_id' => 34,
                'profile_id' => 1,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_processes');
    }
}

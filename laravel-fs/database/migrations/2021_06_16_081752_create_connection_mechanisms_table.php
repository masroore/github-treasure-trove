<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConnectionMechanismsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('connection_mechanisms', function (Blueprint $table): void {
            $table->id();
            $table->string('name_conection', 50);
            $table->boolean('status')->default(true);

            $table->unsignedBigInteger('user_id');
            $table->timestamp('date_register')->nullable();
            $table->string('ip', 20);

            $table->foreign('user_id')->references('id')->on('users');
        });
        DB::table('connection_mechanisms')->insert([
            [
                'name_conection' => 'Sim Card',
                'status' => 1,
                'user_id' => 1,
                'date_register' => '2021-06-26 14:00:00',
                'ip' => '192.168.2.5',
            ],
            [
                'name_conection' => 'Wifi',
                'status' => 1,
                'user_id' => 1,
                'date_register' => '2021-06-26 14:00:00',
                'ip' => '192.168.2.5',
            ],
            [
                'name_conection' => 'Cableado',
                'status' => 1,
                'user_id' => 1,
                'date_register' => '2021-06-26 14:00:00',
                'ip' => '192.168.2.5',
            ],

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connection_mechanisms');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperativesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('operatives', function (Blueprint $table): void {
            $table->id();
            $table->string('name_operative', 50);
            $table->string('owner', 200);
            $table->timestamp('date_operative')->nullable();
            $table->boolean('status')->default(true);

            $table->unsignedBigInteger('user_id');
            $table->timestamp('date_register')->nullable();
            $table->string('ip', 20);

            $table->foreign('user_id')->references('id')->on('users');
        });
        DB::table('operatives')->insert([
            [
                'name_operative' => 'Regular',
                'owner' => 'Bancamiga',
                'date_operative' => now(),
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
        Schema::dropIfExists('operatives');
    }
}

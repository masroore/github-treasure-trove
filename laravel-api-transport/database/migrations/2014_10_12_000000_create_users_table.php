<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('surname');
            $table->string('first_name');
            $table->string('second_name')->default('-')->nullable();
            $table->string('passport_series', 4);
            $table->string('passport_number', 6);
            $table->string('inn', 12)->unique();
            $table->string('scan')->default('-')->nullable();
            $table->date('birthday');
            $table->boolean('deleted')->default(false)->nullable();
            $table->boolean('dismissed')->default(false)->nullable();
            $table->timestamps();
            $table->string('api_token', 80)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}

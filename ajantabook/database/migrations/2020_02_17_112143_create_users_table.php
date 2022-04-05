<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table): void {
                $table->unsignedBigInteger('id')->autoIncrement();
                $table->string('role_id', 191)->default('u');
                $table->string('name', 191)->nullable();
                $table->string('email', 191);
                $table->dateTime('email_verified_at')->nullable();
                $table->string('password', 191)->nullable();
                $table->string('mobile', 191)->nullable();
                $table->string('phone', 191)->nullable();
                $table->integer('city_id')->unsigned()->nullable();
                $table->integer('country_id')->unsigned()->nullable();
                $table->integer('state_id')->unsigned()->nullable();
                $table->text('image', 65535)->nullable();
                $table->string('website', 191)->nullable();
                $table->boolean('status')->nullable()->default(1);
                $table->enum('apply_vender', ['0', '1'])->default('0');
                $table->string('gender', 191)->nullable();
                $table->string('remember_token', 100)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('users');
    }
}

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
        Schema::create('users', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('username')->nullable()->index();
            $table->string('password');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->string('address')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('role_id');
            $table->date('birthday')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('status', 20)->index();
            $table->integer('two_factor_country_code')->nullable();
            $table->integer('two_factor_phone')->nullable();
            $table->text('two_factor_options')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('users');
    }
}

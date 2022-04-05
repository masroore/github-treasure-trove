<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_users', function (Blueprint $table): void {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('username')->default(null)->nullable();
            $table->string('first_name')->default(null)->nullable();
            $table->string('middle_name')->default(null)->nullable();
            $table->string('last_name')->default(null)->nullable();
            $table->string('email', 191)->unique();
            $table->string('password');
            $table->string('contact')->default(null)->nullable();
            $table->string('phone')->default(null)->nullable();
            $table->string('status')->default('1')->comment('1=>Active,0=>Inactive')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_users');
    }
}

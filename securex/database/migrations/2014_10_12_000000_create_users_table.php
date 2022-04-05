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
            $table->increments('id');
            $table->text('first_name');
            $table->text('last_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('password_hint')->nullable();
            $table->string('oauth')->nullable();
            $table->string('oauth_id')->nullable();
            $table->text('phone', 14)->nullable();
            $table->string('dob', 25)->nullable();
            $table->text('address_line1')->nullable();
            $table->text('address_line2')->nullable();
            $table->text('city', 50)->nullable();
            $table->text('zipcode', 10)->nullable();
            $table->text('state', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('avatar', 50)->default('default.png');
            $table->boolean('two_factor_enabled')->default(false);
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->string('status', 12)->default('Active');
            $table->boolean('security_questions')->default(false);
            $table->integer('rng_level')->default('3');
            $table->text('support_pin')->nullable();
            $table->string('type')->default('user');
            $table->string('locale', 5)->default('en');
            $table->string('remark')->nullable();
            $table->string('remark_date')->nullable();
            $table->text('access_key')->nullable();
            $table->boolean('first_login')->default(true);
            $table->string('delete_on')->nullable()->default(null);
            $table->rememberToken();
            $table->timestamps();
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsernameColumn extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('username')->after('id')->nullable();
            $table->dropUnique(['email']);
            $table->string('email')->nullable()->change();
        });

        DB::statement('update users SET username = email');

        Schema::table('users', function (Blueprint $table): void {
            $table->string('username')->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {

        });
    }
}

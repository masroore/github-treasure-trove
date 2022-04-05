<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUsersToEventsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table): void {
            $table->dropColumn('users');
        });

        Schema::table('event_users', function (Blueprint $table): void {
            $table->string('user_status')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table): void {
            $table->json('users')->nullable();
        });

        Schema::table('event_users', function (Blueprint $table): void {
            $table->string('user_status');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('team_user', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')->nullable()->comment('on Delete Cascade');
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');

            $table->foreignId('team_id')->nullable()->comment('on Delete Cascade');
            $table->foreign('team_id')->on('teams')->references('id')->onDelete('cascade');

            $table->timestamps();
        });

        DB::statement('INSERT INTO `team_user` (`user_id`, `team_id`, `created_at`, `updated_at`) VALUES
        (1, 1, now(), now())');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_user', function (Blueprint $table): void {
            $table->dropForeign('team_user_user_id_foreign');
            $table->dropForeign('team_user_team_id_foreign');
        });
        Schema::dropIfExists('team_user');
    }
}

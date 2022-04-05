<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->comment('on Delete Cascade');
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');

            $table->foreignId('team_id')->nullable()->comment('On delete cascade');
            $table->foreign('team_id')->on('teams')->references('id')->onDelete('cascade');

            $table->string('name', 191)->nullable();
            $table->longText('description')->nullable();
            $table->integer('privacy')->default(1)->comment('1 => public to team, 2 => private to project member, 3 => private to me');
            $table->string('default_view')->default('list');
            $table->uuid('uuid')->nullable();
            $table->date('due_date')->nullable()->default(date('Y-m-d'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table): void {
            $table->dropForeign('projects_user_id_foreign');
            $table->dropForeign('projects_team_id_foreign');
        });

        Schema::dropIfExists('projects');
    }
}

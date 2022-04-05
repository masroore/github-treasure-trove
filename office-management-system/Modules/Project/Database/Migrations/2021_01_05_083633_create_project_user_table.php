<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_user', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')->nullable()->comment('on Delete Cascade');
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');

            $table->foreignId('project_id')->nullable()->comment('on Delete Cascade');
            $table->foreign('project_id')->on('projects')->references('id')->onDelete('cascade');

            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->boolean('favourite')->default(false);
            $table->string('default_view')->default('list');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_user', function (Blueprint $table): void {
            $table->dropForeign('project_user_user_id_foreign');
            $table->dropForeign('project_user_project_id_foreign');
        });
        Schema::dropIfExists('project_user');
    }
}

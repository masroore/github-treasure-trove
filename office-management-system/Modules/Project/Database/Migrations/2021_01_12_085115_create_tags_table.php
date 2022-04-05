<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')->nullable()->comment('on Delete set null');
            $table->foreign('user_id')->on('users')->references('id')->onDelete('set null');

            $table->foreignId('workspace_id')->nullable()->comment('on Delete Cascade');
            $table->foreign('workspace_id')->on('workspaces')->references('id')->onDelete('cascade');

            $table->string('name', 191)->nullable();
            $table->string('color', 50)->default('text');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table): void {
            $table->dropForeign('tags_workspace_id_foreign');
            $table->dropForeign('tags_user_id_foreign');
        });
        Schema::dropIfExists('tags');
    }
}

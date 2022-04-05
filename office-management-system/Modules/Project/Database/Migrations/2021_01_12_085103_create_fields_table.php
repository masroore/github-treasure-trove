<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fields', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')->nullable()->comment('on Delete set null');
            $table->foreign('user_id')->on('users')->references('id')->onDelete('set null');

            $table->foreignId('workspace_id')->nullable()->comment('on Delete Cascade');
            $table->foreign('workspace_id')->on('workspaces')->references('id')->onDelete('cascade');

            $table->string('name', 191)->nullable();
            $table->string('type', 50)->default('text');
            $table->string('format', 50)->nullable()->comment('only for type = number');
            $table->string('label', 50)->nullable()->comment('only for type = number');
            $table->string('position', 50)->nullable()->default('right')->comment('only for type = number');
            $table->string('decimal', 50)->nullable()->default(0)->comment('only for type = number');

            $table->boolean('editable')->default(false)->comment('1 => edit only creator, 0=> edit everyone');
            $table->boolean('notify')->default(false)->comment('if type = dropdown/date, 1 => notify everyone when change, 0 => not notify');

            $table->boolean('default')->default(false);
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fields', function (Blueprint $table): void {
            $table->dropForeign('fields_workspace_id_foreign');
            $table->dropForeign('fields_user_id_foreign');
        });
        Schema::dropIfExists('fields');
    }
}

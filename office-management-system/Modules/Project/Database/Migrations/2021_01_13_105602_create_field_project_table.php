<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldProjectTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('field_project', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('field_id')->nullable()->comment('on Delete Cascade');
            $table->foreign('field_id')->on('fields')->references('id')->onDelete('cascade');

            $table->foreignId('project_id')->nullable()->comment('on Delete Cascade');
            $table->foreign('project_id')->on('projects')->references('id')->onDelete('cascade');

            $table->unsignedSmallInteger('order')->default(0);
            $table->boolean('visibility')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('field_project', function (Blueprint $table): void {
            $table->dropForeign('field_project_field_id_foreign');
            $table->dropForeign('field_project_project_id_foreign');
        });
        Schema::dropIfExists('field_project');
    }
}

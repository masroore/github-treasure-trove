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
            $table->bigIncrements('id');
            $table->string('name', 120)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->enum('tag_type', ['products']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
        Schema::table('tags', function (Blueprint $table): void {
            $table->dropSoftDeletes();
        });
    }
}

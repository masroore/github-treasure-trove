<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('skills', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 200);
            $table->string('slug', 300);
            $table->string('icon', 30)->nullable();
            $table->string('difficulty', 30)->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('video')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
}

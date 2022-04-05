<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStylesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('styles', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 120)->nullable();
            $table->string('icon', 40)->nullable();
            $table->string('color', 40)->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('origin', 50)->nullable();
            $table->string('family', 100)->nullable();
            $table->string('music')->nullable();
            $table->string('year', 30)->nullable();
            $table->text('video')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('parent_id')->nullable();
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
        Schema::dropIfExists('styles');
    }
}

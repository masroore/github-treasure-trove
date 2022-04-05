<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('classrooms', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 50);
            $table->string('slug', 80);
            $table->decimal('m2')->nullable();
            $table->integer('capacity')->nullable();
            $table->integer('limit_couples')->nullable();
            $table->decimal('price_hour')->nullable();
            $table->decimal('price_month')->nullable();
            $table->string('currency')->nullable();
            $table->string('floor_type')->nullable();
            $table->string('mirror_type')->nullable();
            $table->boolean('has_bar')->nullable();
            $table->boolean('dance_shoes')->nullable();
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->foreignId('location_id')->nullable()->constrained();
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
        Schema::dropIfExists('classrooms');
    }
}

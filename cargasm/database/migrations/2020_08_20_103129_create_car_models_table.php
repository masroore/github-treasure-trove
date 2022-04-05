<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarModelsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car_models', function (Blueprint $table): void {
            $table->id();
            $table->text('name');
            $table->boolean('status')->default(true);
            $table->string('production_start', 100)->nullable();
            $table->string('production_end', 100)->nullable();
            $table->text('image')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('left_key')->default(0);
            $table->unsignedBigInteger('right_key')->default(0);
            $table->integer('level')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_models');
    }
}

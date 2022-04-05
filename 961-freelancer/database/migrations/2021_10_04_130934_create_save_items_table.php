<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaveItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('save_items', function (Blueprint $table): void {
            $table->id();
            $table->integer('user_id');
            $table->integer('freelancer_id')->nullable();
            $table->integer('job_id')->nullable();
            $table->string('save_type');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('save_items');
    }
}

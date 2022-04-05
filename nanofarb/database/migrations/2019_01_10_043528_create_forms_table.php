<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forms', function (Blueprint $table): void {
            $table->increments('id');
            $table->json('data')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('type');
            $table->ipAddress('ip')->nullable();
            $table->string('url', 512)->nullable();
            $table->string('referer', 512)->nullable();
            $table->unsignedInteger('user_id')->nullable();
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
}

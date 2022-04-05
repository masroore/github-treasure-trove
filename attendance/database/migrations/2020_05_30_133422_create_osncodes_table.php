<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsncodesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('osncodes', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('othernames')->nullable();
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('programme');
            $table->string('amount');
            $table->string('code')->nullable();
            $table->string('status')->default('0');
            $table->string('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('osncodes');
    }
}

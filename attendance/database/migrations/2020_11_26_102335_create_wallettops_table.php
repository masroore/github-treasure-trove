<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWallettopsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wallettops', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('tr_id');
            $table->string('fullname');
            $table->string('indexnumber');
            $table->string('amount');
            $table->string('status')->default('uppaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallettops');
    }
}

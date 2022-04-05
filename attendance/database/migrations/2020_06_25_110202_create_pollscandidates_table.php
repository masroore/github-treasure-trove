<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollscandidatesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pollscandidates', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('pollstype_id');
            $table->string('indexnumber');
            $table->string('fullname');
            $table->string('position');
            $table->string('user_id');
            $table->string('votes')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pollscandidates');
    }
}

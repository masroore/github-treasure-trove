<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentfinesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('studentfines', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('user_id');
            $table->string('studentfeeid');
            $table->string('fine');
            $table->string('feecode');
            $table->string('amount');
            $table->string('studendid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studentfines');
    }
}

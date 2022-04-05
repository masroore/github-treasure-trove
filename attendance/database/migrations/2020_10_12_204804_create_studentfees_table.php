<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentfeesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('studentfees', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('indexnumber');
            $table->string('fee');
            $table->string('feecode');
            $table->string('feeamount');
            $table->string('paid');
            $table->string('owed');
            $table->string('semester');
            $table->string('type')->default('mandatory');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studentfees');
    }
}

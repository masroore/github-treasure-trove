<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('shift_name');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('frequency')->nullable();
            $table->boolean('active')->default(0);
            $table->boolean('days')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

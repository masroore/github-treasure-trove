<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('question');
            $table->longText('answer');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

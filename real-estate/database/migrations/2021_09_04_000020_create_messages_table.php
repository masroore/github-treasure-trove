<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('full_name');
            $table->string('phone_number');
            $table->longText('message');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

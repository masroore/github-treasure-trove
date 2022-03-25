<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatmessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chatmessages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('message')->nullable();
            $table->string('type')->nullable();
            $table->string('is_read')->nullable();
            $table->string('file')->nullable();
            $table->string('filetype')->nullable();
            $table->string('code')->nullable();
            $table->string('semester')->nullable();
            $table->string('year')->nullable();
            $table->string('lectid')->nullable();
            $table->string('lecname')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chatmessages');
    }
}

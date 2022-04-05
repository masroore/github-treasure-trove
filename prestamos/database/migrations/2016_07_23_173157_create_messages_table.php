<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('message_id')->unsigned()->nullable();
            $table->text('title')->nullable();
            $table->text('message')->nullable();
            $table->text('attach_file')->nullable();
            $table->integer('to_id');
            $table->integer('from_id');
            $table->tinyInteger('read')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('messages');
    }
}

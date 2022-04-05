<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('first');
            $table->unsignedBigInteger('second');
            $table->unsignedBigInteger('last_message_id')->nullable();
            $table->unsignedBigInteger('sender')->nullable();
            $table->boolean('first_delete');
            $table->boolean('second_delete');
            $table->integer('unread');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
}

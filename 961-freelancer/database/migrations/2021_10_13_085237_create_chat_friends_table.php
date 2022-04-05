<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatFriendsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_friends', function (Blueprint $table): void {
            $table->id();
            $table->string('conversation_id');
            $table->integer('message_id');
            $table->string('message')->nullable();
            $table->string('job_id')->nullable();
            $table->integer('proposal_id')->nullable();
            $table->integer('sender_id');
            $table->integer('receiver_id');
            $table->string('time');
            $table->enum('message_status', ['read', 'unread', 'empty'])->default('empty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_friends');
    }
}

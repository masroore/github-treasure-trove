<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatMessagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table): void {
            $table->id();
            $table->string('conversation_id');
            $table->integer('message_sender');
            $table->integer('message_receiver');
            $table->string('job_id')->nullable();
            $table->integer('proposal_id')->nullable();
            $table->longText('message_desc')->nullable();
            $table->longText('message_file')->nullable();
            $table->string('message_date');
            $table->string('message_type');
            $table->enum('message_status', ['read', 'unread'])->default('unread');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
}

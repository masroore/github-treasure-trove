<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('body');
            $table->string('redirect')->nullable();
            $table->bigInteger('sender_id');
            $table->morphs('notifiable');
            $table->string('type')->nullable();
            $table->boolean('status')->default(0)->comment('0:unread,1:read,2:open');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
}

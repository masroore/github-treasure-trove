<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table): void {
            $table->id();
            $table->string('ttitle');
            $table->string('slug')->nullable();
            $table->string('country')->nullable();
            $table->string('place')->nullable();
            $table->string('street')->nullable();
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->json('coauthor')->nullable();
            $table->string('category');
            $table->text('descr');
            $table->boolean('is_privacy');
            $table->boolean('confirm_user')->nullable();
            $table->json('users')->nullable();
            $table->boolean('comment_allowed')->default(0);
            $table->boolean('chat_allowed')->default(0);
            $table->boolean('photos_allowed')->default(0);
            $table->unsignedTinyInteger('count_seats')->nullable();
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('sex')->nullable();
            $table->string('date');
            $table->string('time');
            $table->string('complaint')->nullable()->default(0);
            $table->string('lang');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
}

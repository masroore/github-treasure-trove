<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoomMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('zoom_meetings', function (Blueprint $table): void {
            $table->id();
            $table->string('title')->nullable();
            $table->string('meeting_id')->default(0);
            $table->string('user_id')->default(0);
            $table->string('password')->nullable();
            $table->timestamp('start_date')->default(DB::raw('CURRENT_TIMESTAMP(0)'));
            $table->integer('duration')->default(0);
            $table->text('start_url')->nullable();
            $table->string('join_url')->nullable();
            $table->string('status')->default('waiting')->nullable();
            $table->integer('created_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoom_meetings');
    }
}

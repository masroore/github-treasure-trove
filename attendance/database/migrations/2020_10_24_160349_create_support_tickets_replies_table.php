<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportTicketsRepliesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('support_tickets_replies', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('tid');
            $table->integer('cl_id');
            $table->integer('admin_id')->nullable();
            $table->text('admin')->nullable();
            $table->text('name');
            $table->date('date');
            $table->text('message');
            $table->text('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets_replies');
    }
}

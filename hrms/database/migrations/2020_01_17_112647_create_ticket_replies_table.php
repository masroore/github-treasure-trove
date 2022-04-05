<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketRepliesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'ticket_replies',
            function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->integer('ticket_id');
                $table->integer('employee_id');
                $table->string('description');
                $table->integer('created_by');
                $table->integer('is_read')->default('0');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_replies');
    }
}

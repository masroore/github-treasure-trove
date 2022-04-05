<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportTicketFilesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('support_ticket_files', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('ticket_id');
            $table->integer('cl_id');
            $table->integer('admin_id')->nullable();
            $table->text('admin')->nullable();
            $table->text('file_title');
            $table->string('file_size', 20);
            $table->text('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_ticket_files');
    }
}

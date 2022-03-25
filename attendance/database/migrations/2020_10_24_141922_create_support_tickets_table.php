<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('did');
            $table->integer('cl_id');
            $table->integer('admin_id');
            $table->string('indexnumber');
            $table->text('name');
            $table->text('email');
            $table->date('date');
            $table->text('subject');
            $table->text('message');
            $table->enum('status', ['Pending', 'Answered', 'Customer Reply', 'Closed'])->default('Pending');
            $table->text('admin');
            $table->text('replyby')->nullable();
            $table->text('closed_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_tickets');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportTicketsRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_tickets_replies', function (Blueprint $table) {
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_tickets_replies');
    }
}

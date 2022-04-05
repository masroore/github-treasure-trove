<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('email_logs')) {
            Schema::create('email_logs', function (Blueprint $table) {            
				$table->bigIncrements('id');
				$table->string('to_email');
				$table->unsignedBigInteger('auto_responder_id');
				$table->string('template_name');
				$table->tinyInteger('is_read')->default('0');
				$table->tinyInteger('status')->default(0);
				$table->timestamps();
				$table->foreign('auto_responder_id')->references('id')->on('auto_responders')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_logs');
    }
}

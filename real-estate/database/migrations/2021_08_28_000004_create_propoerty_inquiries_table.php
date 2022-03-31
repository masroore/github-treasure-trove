<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropoertyInquiriesTable extends Migration
{
    public function up()
    {
        Schema::create('propoerty_inquiries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name');
            $table->string('phone_number');
            $table->string('email_address')->nullable();
            $table->longText('message');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}

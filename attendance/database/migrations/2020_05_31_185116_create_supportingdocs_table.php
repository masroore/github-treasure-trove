<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportingdocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supportingdocs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('osncode_id')->nullable();
            $table->string('name')->nullable();
            $table->string('filename')->nullable();
            $table->string('doctype')->nullable();
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
        Schema::dropIfExists('supportingdocs');
    }
}

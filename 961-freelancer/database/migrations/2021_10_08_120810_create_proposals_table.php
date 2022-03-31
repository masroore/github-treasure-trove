<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->string('job_id');
            $table->integer('user_id');
            $table->string('budget');
            $table->string('budget_receive');
            $table->string('service_fee');
            $table->longText('cover_letter');
            $table->string('proposal_type');
            $table->string('duration')->nullable();
            $table->integer('proposed_hours')->nullable();
            $table->longText('attachments');
            $table->string('status');
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
        Schema::dropIfExists('proposals');
    }
}

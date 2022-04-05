<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table): void {
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
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
}

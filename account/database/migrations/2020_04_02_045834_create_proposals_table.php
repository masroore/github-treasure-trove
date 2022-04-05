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
        Schema::create(
            'proposals',
            function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('proposal_id');
                $table->unsignedBigInteger('customer_id');
                $table->date('issue_date');
                $table->date('send_date')->nullable();
                $table->integer('category_id');
                $table->integer('status')->default('0');
                $table->integer('discount_apply')->default('0');
                $table->integer('created_by')->default('0');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
}

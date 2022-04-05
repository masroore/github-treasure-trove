<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplyLoansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('apply_loans', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('department_id')->default(1);
            $table->unsignedBigInteger('user_id')->default(1);
            $table->string('title', 255)->nullable();
            $table->string('loan_type', 255)->nullable();
            $table->date('apply_date')->nullable();
            $table->date('loan_date')->nullable();
            $table->double('amount', 12, 2)->default(0);
            $table->double('paid_loan_amount', 12, 2)->default(0);
            $table->integer('total_month')->nullable();
            $table->double('monthly_installment', 12, 2)->default(0);
            $table->text('note')->nullable();
            $table->tinyInteger('approval')->default(0);
            $table->tinyInteger('paid')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->on('users')->references('id');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->on('users')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apply_loans');
    }
}

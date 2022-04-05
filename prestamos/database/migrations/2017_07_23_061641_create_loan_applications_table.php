<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLoanApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loan_applications', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('borrower_id')->unsigned()->nullable();
            $table->integer('loan_product_id');
            $table->decimal('amount', 10, 4)->default(0.00);
            $table->enum('status', [
                'approved',
                'pending',
                'declined',
            ])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('loan_applications');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddStatusToSavingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('savings', function ($table): void {
            $table->enum('status', ['active', 'closed', 'pending', 'declined', 'withdrawn'])->default('pending');
            $table->integer('loan_officer_id')->nullable();
            $table->string('year')->nullable();
            $table->string('month')->nullable();
            $table->decimal('overdraft_limit', 65, 4)->nullable();
            $table->date('approved_date')->nullable();
            $table->date('declined_date')->nullable();
            $table->date('closed_date')->nullable();
            $table->text('approved_notes')->nullable();
            $table->text('declined_notes')->nullable();
            $table->text('closed_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('savings', function ($table): void {
            $table->dropColumn('status');
            $table->dropColumn('loan_officer_id');
            $table->dropColumn('year');
            $table->dropColumn('month');
            $table->dropColumn('overdraft_limit');
            $table->dropColumn('approved_date');
            $table->dropColumn('declined_date');
            $table->dropColumn('closed_date');
            $table->dropColumn('approved_notes');
            $table->dropColumn('declined_notes');
            $table->dropColumn('closed_notes');
        });
    }
}

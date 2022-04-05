<?php

use Illuminate\Database\Migrations\Migration;

class AddBranchesToAllTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('borrowers', function ($table): void {
            $table->integer('branch_id')->nullable();
        });
        Schema::table('assets', function ($table): void {
            $table->integer('branch_id')->nullable();
        });
        Schema::table('capital', function ($table): void {
            $table->integer('branch_id')->nullable();
        });
        Schema::table('emails', function ($table): void {
            $table->integer('branch_id')->nullable();
        });
        Schema::table('expenses', function ($table): void {
            $table->integer('branch_id')->nullable();
        });
        Schema::table('loans', function ($table): void {
            $table->integer('branch_id')->nullable();
        });
        Schema::table('loan_applications', function ($table): void {
            $table->integer('branch_id')->nullable();
        });
        Schema::table('loan_repayments', function ($table): void {
            $table->integer('branch_id')->nullable();
        });
        Schema::table('other_income', function ($table): void {
            $table->integer('branch_id')->nullable();
        });
        Schema::table('payroll', function ($table): void {
            $table->integer('branch_id')->nullable();
        });
        Schema::table('savings', function ($table): void {
            $table->integer('branch_id')->nullable();
        });
        Schema::table('sms', function ($table): void {
            $table->integer('branch_id')->nullable();
        });
        Schema::table('audit_trail', function ($table): void {
            $table->integer('branch_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowers', function ($table): void {
            $table->dropColumn([
                'branch_id',
            ]);
        });
        Schema::table('assets', function ($table): void {
            $table->dropColumn([
                'branch_id',
            ]);
        });
        Schema::table('capital', function ($table): void {
            $table->dropColumn([
                'branch_id',
            ]);
        });
        Schema::table('emails', function ($table): void {
            $table->dropColumn([
                'branch_id',
            ]);
        });
        Schema::table('expenses', function ($table): void {
            $table->dropColumn([
                'branch_id',
            ]);
        });
        Schema::table('loans', function ($table): void {
            $table->dropColumn([
                'branch_id',
            ]);
        });
        Schema::table('loan_applications', function ($table): void {
            $table->dropColumn([
                'branch_id',
            ]);
        });
        Schema::table('loan_repayments', function ($table): void {
            $table->dropColumn([
                'branch_id',
            ]);
        });
        Schema::table('other_income', function ($table): void {
            $table->dropColumn([
                'branch_id',
            ]);
        });
        Schema::table('payroll', function ($table): void {
            $table->dropColumn([
                'branch_id',
            ]);
        });
        Schema::table('savings', function ($table): void {
            $table->dropColumn([
                'branch_id',
            ]);
        });
        Schema::table('sms', function ($table): void {
            $table->dropColumn([
                'branch_id',
            ]);
        });
        Schema::table('audit_trail', function ($table): void {
            $table->dropColumn([
                'branch_id',
            ]);
        });
    }
}

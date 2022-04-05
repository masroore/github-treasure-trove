<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToAllTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table): void {
            $table->index('id');
            $table->index('purchase_date');
        });
        Schema::table('audit_trail', function (Blueprint $table): void {
            $table->index('id');
        });
        Schema::table('capital', function (Blueprint $table): void {
            $table->index('id');
            $table->index('month');
            $table->index('year');
        });
        Schema::table('chart_of_accounts', function (Blueprint $table): void {
            $table->index('id');
        });
        Schema::table('collateral', function (Blueprint $table): void {
            $table->index('id');
        });
        Schema::table('emails', function (Blueprint $table): void {
            $table->index('id');
        });
        Schema::table('expenses', function (Blueprint $table): void {
            $table->index('id');
            $table->index('month');
            $table->index('year');
        });
        Schema::table('guarantor', function (Blueprint $table): void {
            $table->index('id');
            $table->index('unique_number');
        });
        Schema::table('journal_entries', function (Blueprint $table): void {
            $table->index('id');
            $table->index('month');
            $table->index('year');
        });
        Schema::table('loans', function (Blueprint $table): void {
            $table->index('id');
            $table->index('month');
            $table->index('year');
            $table->index('release_date');
            $table->index('maturity_date');
        });
        Schema::table('loan_applications', function (Blueprint $table): void {
            $table->index('id');
        });
        Schema::table('loan_repayments', function (Blueprint $table): void {
            $table->index('id');
            $table->index('borrower_id');
            $table->index('loan_id');
            $table->index('year');
            $table->index('month');
            $table->index('due_date');
            $table->index('collection_date');
        });
        Schema::table('loan_schedules', function (Blueprint $table): void {
            $table->index('id');
            $table->index('borrower_id');
            $table->index('loan_id');
            $table->index('year');
            $table->index('month');
            $table->index('due_date');
        });
        Schema::table('other_income', function (Blueprint $table): void {
            $table->index('id');
            $table->index('year');
            $table->index('month');
        });
        Schema::table('payroll', function (Blueprint $table): void {
            $table->index('id');
            $table->index('user_id');
            $table->index('year');
            $table->index('month');
        });
        Schema::table('products', function (Blueprint $table): void {
            $table->index('id');
        });
        Schema::table('product_check_ins', function (Blueprint $table): void {
            $table->index('id');
            $table->index('supplier_id');
            $table->index('warehouse_id');
        });
        Schema::table('product_check_in_items', function (Blueprint $table): void {
            $table->index('id');
            $table->index('product_check_in_id');
            $table->index('product_id');
        });
        Schema::table('product_check_out_items', function (Blueprint $table): void {
            $table->index('id');
            $table->index('product_check_out_id');
            $table->index('product_id');
        });
        Schema::table('product_check_outs', function (Blueprint $table): void {
            $table->index('id');
            $table->index('loan_id');
            $table->index('borrower_id');
            $table->index('year');
            $table->index('month');
        });
        Schema::table('product_payments', function (Blueprint $table): void {
            $table->index('id');
            $table->index('year');
            $table->index('month');
        });
        Schema::table('savings', function (Blueprint $table): void {
            $table->index('id');
            $table->index('borrower_id');
            $table->index('savings_product_id');
        });
        Schema::table('savings_transactions', function (Blueprint $table): void {
            $table->index('id');
            $table->index('borrower_id');
            $table->index('savings_id');
            $table->index('date');
        });
        Schema::table('sms', function (Blueprint $table): void {
            $table->index('id');
        });
        Schema::table('borrowers', function (Blueprint $table): void {
            $table->index('id');
            $table->index('unique_number');
            $table->index('month');
            $table->index('year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table): void {
            $table->dropIndex('id');
            $table->dropIndex('purchase_date');
        });
        Schema::table('audit_trail', function (Blueprint $table): void {
            $table->dropIndex('id');
        });
        Schema::table('capital', function (Blueprint $table): void {
            $table->dropIndex('id');
            $table->dropIndex('month');
            $table->dropIndex('year');
        });
        Schema::table('chart_of_accounts', function (Blueprint $table): void {
            $table->dropIndex('id');
        });
        Schema::table('collateral', function (Blueprint $table): void {
            $table->dropIndex('id');
        });
        Schema::table('emails', function (Blueprint $table): void {
            $table->dropIndex('id');
        });
        Schema::table('expenses', function (Blueprint $table): void {
            $table->dropIndex('id');
            $table->dropIndex('month');
            $table->dropIndex('year');
        });
        Schema::table('guarantor', function (Blueprint $table): void {
            $table->dropIndex('id');
            $table->dropIndex('unique_number');
        });
        Schema::table('journal_entries', function (Blueprint $table): void {
            $table->dropIndex('id');
            $table->dropIndex('month');
            $table->dropIndex('year');
        });
        Schema::table('loans', function (Blueprint $table): void {
            $table->dropIndex('id');
            $table->dropIndex('month');
            $table->dropIndex('year');
            $table->dropIndex('release_date');
            $table->dropIndex('maturity_date');
        });
        Schema::table('loan_applications', function (Blueprint $table): void {
            $table->dropIndex('id');
        });
        Schema::table('loan_repayments', function (Blueprint $table): void {
            $table->dropIndex('id');
            $table->dropIndex('borrower_id');
            $table->dropIndex('loan_id');
            $table->dropIndex('year');
            $table->dropIndex('month');
            $table->dropIndex('due_date');
            $table->dropIndex('collection_date');
        });
        Schema::table('loan_schedules', function (Blueprint $table): void {
            $table->dropIndex('id');
            $table->dropIndex('borrower_id');
            $table->dropIndex('loan_id');
            $table->dropIndex('year');
            $table->dropIndex('month');
            $table->dropIndex('due_date');
        });
        Schema::table('other_income', function (Blueprint $table): void {
            $table->dropIndex('id');
            $table->dropIndex('year');
            $table->dropIndex('month');
        });
        Schema::table('payroll', function (Blueprint $table): void {
            $table->dropIndex('id');
            $table->dropIndex('user_id');
            $table->dropIndex('year');
            $table->dropIndex('month');
        });
        Schema::table('products', function (Blueprint $table): void {
            $table->dropIndex('id');
        });
        Schema::table('product_check_ins', function (Blueprint $table): void {
            $table->dropIndex('id');
            $table->dropIndex('supplier_id');
            $table->dropIndex('warehouse_id');
        });
        Schema::table('product_check_in_items', function (Blueprint $table): void {
            $table->dropIndex('id');
            $table->dropIndex('product_check_in_id');
            $table->dropIndex('product_id');
        });
        Schema::table('product_check_out_items', function (Blueprint $table): void {
            $table->dropIndex('id');
            $table->dropIndex('product_check_out_id');
            $table->dropIndex('product_id');
        });
        Schema::table('product_check_outs', function (Blueprint $table): void {
            $table->dropIndex('id');
            $table->dropIndex('loan_id');
            $table->dropIndex('borrower_id');
            $table->dropIndex('year');
            $table->dropIndex('month');
        });
        Schema::table('product_payments', function (Blueprint $table): void {
            $table->dropIndex('id');
            $table->dropIndex('year');
            $table->dropIndex('month');
        });
        Schema::table('savings', function (Blueprint $table): void {
            $table->dropIndex('id');
            $table->dropIndex('borrower_id');
            $table->dropIndex('savings_product_id');
        });
        Schema::table('savings_transactions', function (Blueprint $table): void {
            $table->dropIndex('id');
            $table->dropIndex('borrower_id');
            $table->dropIndex('savings_id');
            $table->dropIndex('date');
        });
        Schema::table('sms', function (Blueprint $table): void {
            $table->dropIndex('id');
        });
        Schema::table('borrowers', function (Blueprint $table): void {
            $table->dropIndex('id');
            $table->dropIndex('unique_number');
            $table->dropIndex('month');
            $table->dropIndex('year');
        });
    }
}

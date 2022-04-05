<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldInInvoicePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(
            'invoice_payments',
            function (Blueprint $table): void {
                $table->string('order_id')->nullable()->after('payment_method');
                $table->string('currency')->nullable()->after('payment_method');
                $table->string('txn_id')->nullable()->after('payment_method');
                $table->string('payment_type')->default('Manually')->after('payment_method');
                $table->string('receipt')->nullable()->after('payment_method');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'invoice_payments',
            function (Blueprint $table): void {
                $table->dropColumn('order_id');
                $table->dropColumn('currency');
                $table->dropColumn('txn_id');
                $table->dropColumn('payment_type');
                $table->dropColumn('receipt');
            }
        );
    }
}

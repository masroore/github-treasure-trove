<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameInvoiceReceiptNumber extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table): void {
            $table->renameColumn('invoice_number', 'receipt_number');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table): void {

        });
    }
}

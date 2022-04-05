<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('pre_invoices', 'invoices');

        Schema::rename('pre_invoice_details', 'invoice_details');

        Schema::table('invoice_details', function (Blueprint $table): void {
            if (DB::connection()->getPDO()->getAttribute(PDO::ATTR_DRIVER_NAME) !== 'sqlite') {
                $table->dropForeign('pre_invoice_details_pre_invoice_id_foreign');
            }

            $table->renameColumn('pre_invoice_id', 'invoice_id');
        });

        Schema::table('payments', function (Blueprint $table): void {
            if (DB::connection()->getPDO()->getAttribute(PDO::ATTR_DRIVER_NAME) !== 'sqlite') {
                $table->dropForeign('payments_pre_invoice_id_foreign');
            }

            $table->renameColumn('pre_invoice_id', 'invoice_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
}

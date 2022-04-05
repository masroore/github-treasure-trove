<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnToCustomerAddressesAndTransactionTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('customer_addresses', function (Blueprint $table): void {
            $table->dropColumn('customer_id');
            $table->unsignedBigInteger('customer_user_id')->nullable()->default(null)->after('id');
        });

        Schema::table('customer_transactions', function (Blueprint $table): void {
            $table->dropColumn('customer_id');
            $table->unsignedBigInteger('customer_user_id')->nullable()->default(null)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
}

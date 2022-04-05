<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBalanceToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(
            'customers',
            function (Blueprint $table): void {
                $table->float('balance')->default('0.00')->after('lang');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'customers',
            function (Blueprint $table): void {
                $table->dropColumn('balance');
            }
        );
    }
}

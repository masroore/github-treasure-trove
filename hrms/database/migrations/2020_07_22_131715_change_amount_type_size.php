<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAmountTypeSize extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(
            'account_lists',
            function (Blueprint $table): void {
                $table->float('initial_balance', 25, 2)->default(0.00)->change();
            }
        );

        Schema::table(
            'assets',
            function (Blueprint $table): void {
                $table->float('amount', 25, 2)->default(0.00)->change();
            }
        );

        Schema::table(
            'employees',
            function (Blueprint $table): void {
                $table->float('salary', 25, 2)->default(0.00)->change();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'account_lists',
            function (Blueprint $table): void {
                $table->dropColumn('initial_balance');
            }
        );

        Schema::table(
            'assets',
            function (Blueprint $table): void {
                $table->dropColumn('amount');
            }
        );

        Schema::table(
            'employees',
            function (Blueprint $table): void {
                $table->dropColumn('salary');
            }
        );
    }
}

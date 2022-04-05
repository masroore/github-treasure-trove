<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTaxColumnType extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(
            'proposal_products',
            function (Blueprint $table): void {
                $table->string('tax', '50')->nullable()->change();
            }
        );
        Schema::table(
            'invoice_products',
            function (Blueprint $table): void {
                $table->string('tax', '50')->nullable()->change();
            }
        );
        Schema::table(
            'bill_products',
            function (Blueprint $table): void {
                $table->string('tax', '50')->nullable()->change();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'proposal_products',
            function (Blueprint $table): void {
                $table->dropColumn('tax');
            }
        );
        Schema::table(
            'invoice_products',
            function (Blueprint $table): void {
                $table->dropColumn('tax');
            }
        );
        Schema::table(
            'bill_products',
            function (Blueprint $table): void {
                $table->dropColumn('tax');
            }
        );
    }
}

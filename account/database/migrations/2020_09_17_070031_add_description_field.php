<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionField extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(
            'proposal_products',
            function (Blueprint $table): void {
                $table->text('description')->nullable()->after('price');
            }
        );

        Schema::table(
            'invoice_products',
            function (Blueprint $table): void {
                $table->text('description')->nullable()->after('price');
            }
        );

        Schema::table(
            'bill_products',
            function (Blueprint $table): void {
                $table->text('description')->nullable()->after('price');
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
                $table->dropColumn('description');
            }
        );

        Schema::table(
            'invoice_products',
            function (Blueprint $table): void {
                $table->dropColumn('description');
            }
        );

        Schema::table(
            'bill_products',
            function (Blueprint $table): void {
                $table->dropColumn('description');
            }
        );
    }
}

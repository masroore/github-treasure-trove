<?php

use Illuminate\Database\Migrations\Migration;

class AddCheckoutToLoanTableTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('loans', function ($table): void {
            $table->integer('product_check_out_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function ($table): void {
            $table->dropColumn([
                'product_check_out_id',
            ]);
        });
    }
}

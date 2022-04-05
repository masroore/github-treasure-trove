<?php

use Illuminate\Database\Migrations\Migration;

class AddApplicationFeeToLoansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('loans', function ($table): void {
            $table->decimal('processing_fee', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function ($table): void {
            $table->dropColumn([
                'processing_fee',
            ]);
        });
    }
}

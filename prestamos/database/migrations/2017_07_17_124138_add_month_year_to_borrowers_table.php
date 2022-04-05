<?php

use Illuminate\Database\Migrations\Migration;

class AddMonthYearToBorrowersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('borrowers', function ($table): void {
            $table->string('month')->nullable();
            $table->string('year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowers', function ($table): void {
            $table->dropColumn([
                'month',
                'year',
            ]);
        });
    }
}

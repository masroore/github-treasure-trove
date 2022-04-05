<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddWaiveToLoanSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('loan_schedules', function ($table): void {
            $table->decimal('fees_waived', 65, 4)->nullable();
            $table->decimal('penalty_waived', 65, 4)->nullable();
            $table->decimal('interest_waived', 65, 4)->nullable();
            $table->decimal('principal_waived', 65, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_schedules', function ($table): void {
            $table->dropColumn('fees_waived');
            $table->dropColumn('penalty_waived');
            $table->dropColumn('interest_waived');
            $table->dropColumn('principal_waived');
        });
    }
}

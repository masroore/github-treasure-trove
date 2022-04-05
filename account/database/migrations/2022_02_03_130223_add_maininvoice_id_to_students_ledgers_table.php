<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaininvoiceIdToStudentsLedgersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students_ledgers', function (Blueprint $table): void {
            $table->integer('maininvoice_id')->default(0)->after('journal_entries_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students_ledgers', function (Blueprint $table): void {
        });
    }
}

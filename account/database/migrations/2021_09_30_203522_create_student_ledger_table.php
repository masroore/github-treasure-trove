<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentLedgerTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_ledger', function (Blueprint $table): void {
            $table->id();
            $table->integer('journal_items_id')->default(0);
            $table->integer('student_id')->default(0);
            $table->string('accounts_reg')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_ledger');
    }
}

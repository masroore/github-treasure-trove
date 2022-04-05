<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsLedgersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students_ledgers', function (Blueprint $table): void {
            $table->id();
            $table->integer('journal_entries_id')->default(0);
            $table->date('date');
            $table->integer('account')->default(0);
            $table->integer('vr_no')->default(0);
            $table->string('narration')->nullable();
            // $table->text('description')->nullable();
            $table->float('debit')->default(0.0);
            $table->float('credit')->default(0.0);
            $table->float('balance')->default(0.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_ledgers');
    }
}

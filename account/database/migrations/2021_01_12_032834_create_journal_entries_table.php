<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalEntriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'journal_entries',
            function (Blueprint $table): void {
                $table->id();
                $table->date('date');
                $table->string('reference')->nullable();
                $table->text('description')->nullable();
                $table->integer('journal_id')->default(0);
                $table->integer('created_by')->default(0);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_entries');
    }
}

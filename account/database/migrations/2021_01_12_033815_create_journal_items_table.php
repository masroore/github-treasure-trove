<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'journal_items',
            function (Blueprint $table): void {
                $table->id();
                $table->integer('journal')->default(0);
                $table->integer('account')->default(0);
                $table->text('description')->nullable();
                $table->float('debit')->default(0.0);
                $table->float('credit')->default(0.0);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_items');
    }
}

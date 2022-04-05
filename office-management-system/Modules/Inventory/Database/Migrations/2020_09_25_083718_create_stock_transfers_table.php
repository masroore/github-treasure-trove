<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTransfersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_transfers', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('sendable_id');
            $table->string('sendable_type');
            $table->unsignedBigInteger('receivable_id');
            $table->string('receivable_type');
            $table->date('date');
            $table->boolean('status')->default(false);
            $table->date('sent_at')->nullable();
            $table->date('received_at')->nullable();
            $table->longText('documents')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transfers');
    }
}

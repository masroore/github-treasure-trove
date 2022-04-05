<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table): void {
            $table->id();
            $table->string('tx_id')->nullable();
            $table->string('voucher_type')->nullable()->comment('CV => Cash Voucher, BV => Bank Voucher, JV => Journal Voucher, CRV => Contra Voucher');
            $table->unsignedBigInteger('referable_id')->nullable();
            $table->unsignedBigInteger('account_type')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->string('referable_type', 255)->nullable();
            $table->double('amount', 16, 2)->default(0);
            $table->string('payment_type')->nullable();
            $table->string('narration')->nullable();
            $table->tinyInteger('is_approve')->default(1)->comment('0 => pending, 1 => Approve, 2 => Cancelled');
            $table->tinyInteger('is_transfer')->default(0)->comment('money transfer from here to there');
            $table->date('date')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->on('users')->references('id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
}

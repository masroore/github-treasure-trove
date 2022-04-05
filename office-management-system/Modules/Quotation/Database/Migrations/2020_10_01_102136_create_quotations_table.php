<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('quotationable_id')->nullable();
            $table->string('quotationable_type')->nullable();
            $table->double('amount', 16, 2)->default(0);
            $table->string('invoice_no')->nullable();
            $table->string('ref_no')->nullable();
            $table->double('total_quantity', 16, 2)->default(0);
            $table->double('total_discount', 16, 2)->default(0);
            $table->double('total_vat', 16, 2)->default(0);
            $table->double('shipping_charge', 16, 2)->default(0);
            $table->double('other_charge', 16, 2)->default(0);
            $table->double('payable_amount', 16, 2)->default(0);
            $table->double('discount_amount', 16, 2)->default(0);
            $table->tinyInteger('discount_type')->default(1);
            $table->timestamp('date')->nullable();
            $table->Date('valid_till_date')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('document')->nullable();
            $table->string('signature')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('convert_status')->default(0);
            $table->longText('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->on('users')->references('id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
}

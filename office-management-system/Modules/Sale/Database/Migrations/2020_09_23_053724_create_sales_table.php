<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('agent_user_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('saleable_id')->nullable();
            $table->string('saleable_type');
            $table->double('amount', 16, 2)->default(0);
            $table->double('total_quantity', 16, 2)->default(0);
            $table->double('total_discount', 16, 2)->default(0);
            $table->double('total_tax', 16, 2)->default(0);
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->double('shipping_charge', 16, 2)->default(0);
            $table->double('other_charge', 16, 2)->default(0);
            $table->double('payable_amount', 16, 2)->default(0);
            $table->string('ref_no')->nullable();
            $table->string('invoice_no')->nullable();
            $table->double('discount_amount', 16, 2)->default(0);
            $table->tinyInteger('discount_type')->default(1);
            $table->boolean('mail_status')->default(0);
            $table->tinyInteger('status')->default(false)->comment('0 => Unpaid, 1 => Paid & 2 => Partial');
            $table->tinyInteger('type')->default(false)->comment(' 1 => Regular, 0 => Conditional,2 => POS');
            $table->tinyInteger('is_approved')->default(false)->comment(' 0 => No ,1 => Yes');
            $table->tinyInteger('is_draft')->default(false)->comment(' 0 => No ,1 => Yes');
            $table->date('date')->nullable();
            $table->longText('notes')->nullable();
            $table->longText('return_note')->nullable();
            $table->longText('document')->nullable();
            $table->string('signature')->nullable();
            $table->longText('return_document')->nullable();
            $table->tinyInteger('return_status')->default(2)->comment('0 => Pending, 1 => Accepted');
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
        Schema::dropIfExists('sales');
    }
}

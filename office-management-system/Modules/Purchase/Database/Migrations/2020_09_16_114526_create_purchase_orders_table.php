<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('purchasable_id');
            $table->unsignedBigInteger('cnf_id')->nullable();
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->string('purchasable_type');
            $table->date('date');
            $table->double('amount', 16, 2)->default(0);
            $table->bigInteger('total_quantity')->default(0);
            $table->double('total_discount', 16, 2)->default(0);
            $table->double('discount_amount', 16, 2)->default(0);
            $table->boolean('discount_type')->default(2)->comment('2 => percentage, 1 => amount');
            $table->double('total_vat', 16, 2)->default(0);
            $table->double('shipping_charge', 16, 2)->default(0);
            $table->double('other_charge', 16, 2)->default(0);
            $table->double('payable_amount', 16, 2)->default(0);
            $table->string('payment_method')->nullable();
            $table->string('invoice_no');
            $table->string('ref_no')->nullable();
            $table->string('shipping_address')->nullable();
            $table->longText('documents')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('return_status')->default(2)->comment('0=>pending,1=>approved,2=>default');
            $table->boolean('added_to_stock')->default(false);
            $table->boolean('is_paid')->default(false)->comment('0=>no,1=>partial,2=>paid');
            $table->longText('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
}

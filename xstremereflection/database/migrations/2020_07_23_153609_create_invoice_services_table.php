<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceServicesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoice_services', function (Blueprint $table): void {
            $table->id();
            $table->timestamps();
            $table->integer('qty');
            $table->integer('invoiceId');
            $table->integer('packageId');
            $table->integer('discount')->nullable();
            $table->integer('discountType')->nullable();
            $table->decimal('total', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_services');
    }
}

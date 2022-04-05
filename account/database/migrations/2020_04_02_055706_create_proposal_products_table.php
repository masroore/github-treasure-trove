<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'proposal_products',
            function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->integer('proposal_id');
                $table->integer('product_id');
                $table->integer('quantity');
                $table->float('tax')->default('0.00');
                $table->float('discount')->default('0.00');
                $table->float('price')->default('0.00');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_products');
    }
}

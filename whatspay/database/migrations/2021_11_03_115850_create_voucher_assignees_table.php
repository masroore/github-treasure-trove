<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherAssigneesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_assignees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')
                ->references('id')
                ->on('stores')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('voucher_id')
                ->references('id')
                ->on('discount_vouchers')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->unique(['store_id', 'voucher_id']);
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher_assignees');
    }
}

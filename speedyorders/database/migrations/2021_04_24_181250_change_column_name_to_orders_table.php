<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnNameToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            $table->renameColumn('customer_id', 'customer_user_id');
            $table->renameColumn('address1', 'address_1');
            $table->renameColumn('address2', 'address_2');
            $table->renameColumn('postal_code', 'postcode');
            $table->renameColumn('payment_address1', 'payment_address_1');
            $table->renameColumn('payment_address2', 'payment_address_2');
            $table->renameColumn('payment_postalcode', 'payment_postcode');
            $table->renameColumn('shipping_address1', 'shipping_address_1');
            $table->renameColumn('shipping_address2', 'shipping_address_2');
            $table->renameColumn('shipping_postalcode', 'shipping_postcode');
        });
    }

    public function down(): void
    {
    }
}

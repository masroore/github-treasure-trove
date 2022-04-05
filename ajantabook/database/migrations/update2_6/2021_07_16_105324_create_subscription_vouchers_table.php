<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionVouchersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('subscription_vouchers')) {
            Schema::create('subscription_vouchers', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('code', 191);
                $table->string('distype', 100);
                $table->string('amount', 191);
                $table->string('link_by', 100);
                $table->string('dis_applytype', 100);
                $table->integer('plan_id')->unsigned()->nullable();
                $table->integer('maxusage')->unsigned()->nullable();
                $table->integer('status')->default(1);
                $table->dateTime('expirydate');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_vouchers');
    }
}

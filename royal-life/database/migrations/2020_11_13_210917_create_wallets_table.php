<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->bigInteger('iduser')->unsigned();
            $table->foreign('iduser')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('referred_id')->unsigned()->nullable();
            $table->foreign('referred_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('orden_purchases_id')->unsigned()->nullable();
            // $table->foreign('orden_purchases_id')->references('id')->on('orden_purchases');
            $table->bigInteger('liquidation_id')->unsigned()->nullable();
            $table->foreign('liquidation_id')->references('id')->on('liquidactions')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('monto')->default(0)->comment('entrada de cash');
            //$table->decimal('debito')->default(0)->comment('entrada de cash');
            //$table->decimal('credito')->default(0)->comment('salida de cash');
            //$table->decimal('balance')->nullable()->comment('balance del cash');
            $table->string('descripcion');
            $table->tinyInteger('status')->default(0)->comment('0 - En espera, 1 - Pagado (liquidado), 2 - Cancelado');
            $table->tinyInteger('tipo_transaction')->default(0)->comment('0 - comision, 1 - retiro');
            $table->tinyInteger('liquidado')->default(0)->comment('0 - sin liquidar, 1 - liquidado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
}

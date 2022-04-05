<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orden_purchases', function (Blueprint $table): void {
            $table->bigIncrements('id')->unsigned();
            $table->string('name')->nullable();
            $table->bigInteger('iduser')->unsigned();
            $table->foreign('iduser')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            //        $table->bigInteger('categories_id')->unsigned();
            //      $table->foreign('categories_id')->references('id')->on('categories');
            $table->bigInteger('package_id')->unsigned();
            $table->foreign('package_id')->references('id')->on('packages')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('monto')->nullable();
            $table->decimal('total');
            $table->text('idtransacion')->nullable()->comment('ID de la transacion');
            $table->text('id_coinbase')->nullable()->comment('ID de coinbase');
            $table->text('code_coinbase')->nullable()->comment('Code de coinbase');
            $table->enum('status', [0, 1, 2, 3])->default(0)->comment('0 - En Espera, 1 - Completada, 2 - Rechazada, 3 - Cancelada');
            $table->bigInteger('categories_id')->unsigned();
            $table->foreign('categories_id')->references('id')->on('categories');
            $table->string('lastname')->nullable();
            $table->string('country')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_services');
    }
}

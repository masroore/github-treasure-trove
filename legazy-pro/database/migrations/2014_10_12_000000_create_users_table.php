<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table): void {
            $table->bigIncrements('id')->unsigned();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('fullname')->nullable();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('password');
            $table->string('address')->nullable();
            $table->double('wallet')->default(0);
            $table->enum('admin', [0, 1])->default(0)->comment('permite saber si un usuario es admin o no');
            $table->enum('status', [0, 1, 2])->default(0)->comment('0 - inactivo, 1 - activo, 2 - eliminado');
            // $table->enum('verify', [0, 1])->default(0)->comment('permite saber si un usuario esta verificado o no');
            $table->bigInteger('referred_id')->default(1)->comment('ID del usuario patrocinador');
            $table->bigInteger('not_payment_binary_point_izq')->default(0)->comment('el id regisrado es la orden que que no cobrare');
            $table->bigInteger('not_payment_binary_point_der')->default(0)->comment('el id regisrado es la orden que que no cobrare');
            $table->bigInteger('binary_id')->default(1)->comment('ID del usuario binario');
            $table->enum('binary_side', ['I', 'D'])->nullable()->comment('Permite saber si esta en la derecha o izquierda en el binario');
            $table->enum('binary_side_register', ['I', 'D'])->default('I')->comment('Permite saber porque lado va a registrar a un nuevo usuario');
            $table->longtext('dni')->nullable();
            $table->longtext('wallet_address')->nullable();
            $table->longtext('photoDB')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}

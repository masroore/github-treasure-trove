<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storages', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20);
            $table->string('name_storage', 50);
            $table->string('phone', 20);
            $table->string('email', 50)->nullable();
	        $table->boolean('status')->default(true);

            $table->unsignedBigInteger('bank_id');
            $table->unsignedBigInteger('type_storage_id');
            $table->unsignedBigInteger('telephone_operator_id');
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('responsible_id');

            $table->unsignedBigInteger('user_id');
            $table->timestamp('register_date')->nullable();
            $table->string('ip', 20);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->foreign('type_storage_id')->references('id')->on('type_storages');
            $table->foreign('telephone_operator_id')->references('id')->on('telephone_operators');
        });
        DB::table('storages')->insert([
           [
            'code' => '0001',
            'name_storage' => 'Almacen Principal (Administración)',
            'phone' => '6391638',
            'email' => 'seguridad.info@puropago.com',
            'bank_id' => 1,
            'type_storage_id' => 1,
            'telephone_operator_id' => 1,
            'address_id' => 1,
            'responsible_id' => 1,
            'user_id' => 1,
            'register_date' => now(),
            'ip' => \Request::ip(),
            'status' => 1,
          ],
          [
            'code' => '0003',
            'name_storage' => 'Correctivos',
            'phone' => '1234567',
            'email' => 'correctivos@puropago.com',
            'bank_id' => 1,
            'type_storage_id' => 1,
            'telephone_operator_id' => 1,
            'address_id' => 1,
            'responsible_id' => 1,
            'user_id' => 1,
            'register_date' => now(),
            'ip' => \Request::ip(),
            'status' => 1,
          ],
          [
            'code' => '0004',
            'name_storage' => 'Aliados',
            'phone' => '1234568',
            'email' => 'aliados@puropago.com',
            'bank_id' => 1,
            'type_storage_id' => 1,
            'telephone_operator_id' => 1,
            'address_id' => 1,
            'responsible_id' => 1,
            'user_id' => 1,
            'register_date' => now(),
            'ip' => \Request::ip(),
            'status' => 1,
          ],
          [
            'code' => '0005',
            'name_storage' => 'Contabilidad',
            'phone' => '1234596',
            'email' => 'contabilidad@puropago.com',
            'bank_id' => 1,
            'type_storage_id' => 1,
            'telephone_operator_id' => 1,
            'address_id' => 1,
            'responsible_id' => 1,
            'user_id' => 1,
            'register_date' => now(),
            'ip' => \Request::ip(),
            'status' => 1,
          ],
          [
            'code' => '0006',
            'name_storage' => 'Draza',
            'phone' => '1234596',
            'email' => 'draza@puropago.com',
            'bank_id' => 1,
            'type_storage_id' => 1,
            'telephone_operator_id' => 1,
            'address_id' => 1,
            'responsible_id' => 1,
            'user_id' => 1,
            'register_date' => now(),
            'ip' => \Request::ip(),
            'status' => 1,
          ] 
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storages');
    }
}

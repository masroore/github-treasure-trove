<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_storages', function (Blueprint $table) {
            $table->id();
            $table->string('description', 200);
			$table->boolean('status')->default(true);
			
			$table->timestamp('register_date')->nullable();
      $table->string('ip', 20);
      $table->unsignedBigInteger('user_id');
      $table->unsignedBigInteger('bank_id');
      $table->foreign('user_id')->references('id')->on('users');
      $table->foreign('bank_id')->references('id')->on('banks');
            
        });
        DB::table('type_storages')->insert([
          [
            'description' => 'OFICINA PRINCIPAL',
            'status' => 1,			
            'bank_id' => 1,      
      			'register_date' => now(),
      			'ip' => \Request::ip(),
      			'user_id' => 1,
          ],
          [
            'description' => 'AGENCIA',
            'status' => 1,	
            'bank_id' => 1, 		
      			'register_date' => now(),
      			'ip' => \Request::ip(),
      			'user_id' => 1,
          ],
          [
            'description' => 'ALIADO',
            'status' => 1,	
            'bank_id' => 1, 		
      			'register_date' => now(),
      			'ip' => \Request::ip(),
      			'user_id' => 1,
          ],
          [
            'description' => 'MRW',
            'status' => 1,	
            'bank_id' => 1, 		
      			'register_date' => now(),
      			'ip' => \Request::ip(),
      			'user_id' => 1,
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
        Schema::dropIfExists('type_storages');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_storages', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('storage_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('storage_id')->references('id')->on('storages');
        });
        DB::table('user_storages')->insert([
			[
				'user_id' => 1,
				'storage_id' => 1,
			],
			[
				'user_id' => 2,
				'storage_id' => 1,
			],
			[
				'user_id' => 2,
				'storage_id' => 2,
			],
			[
				'user_id' => 3,
				'storage_id' => 1,
			],
			[
				'user_id' => 4,
				'storage_id' => 1,
			],
			[
				'user_id' => 5,
				'storage_id' => 1,
			],
			[
				'user_id' => 6,
				'storage_id' => 1,
			],
			[
				'user_id' => 7,
				'storage_id' => 1,
			],
			[
				'user_id' => 8,
				'storage_id' => 1,
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
        Schema::dropIfExists('user_storages');
    }
}

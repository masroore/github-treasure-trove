<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->text('rate')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('symbol')->nullable();
            $table->enum('position', ['left', 'right'])->default('left');
        });
        \Illuminate\Support\Facades\DB::table('currencies')->insert([
            [

                'rate' => '1.00',
                'code' => 'USD',
                'name' => 'United States dollar',
                'symbol' => '$',
                'position' => 'left',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('currencies');
    }
}

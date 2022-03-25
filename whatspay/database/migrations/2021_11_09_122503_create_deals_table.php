<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('original_price');
            $table->string('deal_price');
            $table->integer('quantity');
            $table->string('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('never_expires')->default(0);
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('every_time')->default(0);
            $table->boolean('status')->default(1);
            $table->text('specification')->nullable();
            $table->text('tags')->nullable();
            $table->text('labels')->nullable();
            $table->foreignId('store_id')
                ->references('id')
                ->on('stores')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
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
        Schema::dropIfExists('deals');
    }
}

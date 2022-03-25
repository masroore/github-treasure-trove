<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('deal_id')
                ->references('id')
                ->on('deals')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->boolean('status')->default(0);

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
        Schema::dropIfExists('deal_groups');
    }
}

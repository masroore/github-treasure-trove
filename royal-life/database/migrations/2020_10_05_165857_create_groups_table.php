<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up()
    // {
    //     Schema::create('groups', function (Blueprint $table) {
    //         $table->bigIncrements('id')->unsigned();
    //         $table->string('name')->unique();
    //         $table->text('img')->nullable();
    //         $table->text('description')->nullable();
    //         $table->enum('status', [0, 1])->default(1)->comment('0 - desactivado, 1 - activado');
    //         $table->timestamps();
    //     });
    // }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //   Schema::dropIfExists('categories');
    }
}

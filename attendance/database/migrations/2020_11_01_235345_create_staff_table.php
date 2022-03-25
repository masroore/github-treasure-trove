<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('role')->nullable();
            $table->string('fullname')->nullable();
            $table->string('dateofbirth')->nullable();
            $table->string('address')->nullable();
            $table->string('faculty')->nullable();
            $table->string('gender')->nullable();
            $table->string('religion')->nullable();
            $table->string('qualification')->nullable();
            $table->string('number')->nullable();
            $table->string('fathername')->nullable();
            $table->string('mothername')->nullable();
            $table->string('maritalstatus')->nullable();
            $table->string('workexperience')->nullable();
            $table->string('eployid')->nullable();
            $table->string('salarygrade')->nullable();
            $table->string('salary')->nullable();
            $table->string('acctitle')->nullable();
            $table->string('accnum')->nullable();
            $table->string('bankname')->nullable();
            $table->string('bankbranch')->nullable();
            $table->string('resumedoc')->nullable();
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
        Schema::dropIfExists('staff');
    }
}

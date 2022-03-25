<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTBLTMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBLTM', function (Blueprint $table) {
            $table->id();
            $table->integer('MID')->default('0');
            $table->string('VTYPE')->nullable();
            $table->integer('STUDENTID')->default('0');
            $table->date('FROMDATE')->nullable();
            $table->date('TODATE')->nullable();
            $table->integer('CAMPUSID')->default('0');
            $table->string('CHALLANO')->nullable();
            $table->date('CHALLANDUEDATE')->nullable();
            $table->integer('LATEFEEFINE')->default('0');
            $table->integer('AREARS')->default('0');
            $table->integer('CHALLANVALUE')->default('0');
            $table->integer('CHALLANAFTERDUEDATE')->default('0');
            $table->date('PAIDDATE')->nullable();
            $table->string('STATUS')->nullable();
            $table->char('POST', 100)->nullable();
            $table->string('CREATEDBY')->nullable();
            $table->date('CREATIONDATE')->nullable();
            $table->string('MODIFIEDBY')->nullable();
            $table->date('MODIFICATIONDATE')->nullable();
            $table->integer('CATEGORYID')->default('0');
            $table->integer('CLASSID')->default('0');
            $table->integer('SECTIONID')->default('0');
            $table->integer('STUDENTCODE')->default('0');
            $table->integer('ADJUSTMENT')->default('0');
            $table->string('ADJUSTMENTREMARKS')->nullable();
            $table->integer('PAIDAMOUNT')->default('0');
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
        Schema::dropIfExists('t_b_l_t_m_s');
    }
}

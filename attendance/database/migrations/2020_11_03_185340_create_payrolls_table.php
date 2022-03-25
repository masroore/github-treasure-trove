<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('role')->nullable();
            $table->string('month')->nullable();
            $table->string('monthalise')->nullable();
            $table->string('year')->nullable();
            $table->string('earning')->nullable();
            $table->string('earnamnts')->nullable();
            $table->string('totalearn')->nullable();
            $table->string('deduction')->nullable();
            $table->string('deductamnts')->nullable();
            $table->string('totalded')->nullable();
            $table->string('grosssalary')->nullable();
            $table->string('netsalary')->nullable();
            $table->string('tax')->nullable();
            $table->string('note')->nullable();
            $table->string('paymentdate')->nullable();
            $table->string('modepay')->nullable();
            $table->string('payslipid')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('payrolls');
    }
}

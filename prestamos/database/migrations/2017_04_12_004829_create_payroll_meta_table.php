<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePayrollMetaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payroll_meta', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('payroll_id')->unsigned();
            $table->integer('payroll_template_meta_id')->unsigned()->nullable();
            $table->string('value')->nullable();
            $table->enum(
                'position',
                ['top_left', 'top_right', 'bottom_left', 'bottom_right']
            )->default('bottom_left');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('payroll_meta');
    }
}

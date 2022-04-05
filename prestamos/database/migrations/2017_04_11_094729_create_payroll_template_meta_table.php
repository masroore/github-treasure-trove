<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePayrollTemplateMetaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payroll_template_meta', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('payroll_template_id')->unsigned();
            $table->string('name')->nullable();
            $table->enum(
                'position',
                ['top_left', 'top_right', 'bottom_left', 'bottom_right']
            )->default('bottom_left');
            $table->tinyInteger('is_default')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('payroll_template_meta');
    }
}

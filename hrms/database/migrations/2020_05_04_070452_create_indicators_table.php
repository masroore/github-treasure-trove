<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'indicators',
            function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->integer('branch')->default(0);
                $table->integer('department')->default(0);
                $table->integer('designation')->default(0);
                $table->integer('customer_experience')->default(0);
                $table->integer('marketing')->default(0);
                $table->integer('administration')->default(0);
                $table->integer('professionalism')->default(0);
                $table->integer('integrity')->default(0);
                $table->integer('attendance')->default(0);
                $table->integer('created_user')->default(0);
                $table->integer('created_by')->default(0);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicators');
    }
}

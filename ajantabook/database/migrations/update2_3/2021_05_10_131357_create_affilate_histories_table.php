<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffilateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('affilate_histories')) {
            Schema::create('affilate_histories', function (Blueprint $table): void {
                $table->id();
                $table->integer('refer_user_id')->unsigned();
                $table->longText('log')->nullable();
                $table->integer('user_id')->unsigned();
                $table->double('amount')->default(0);
                $table->integer('procces')->unsigned();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affilate_histories');
    }
}

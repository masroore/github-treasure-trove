<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIgAuthDatasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ig_auth_datas', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->text('access_token');
            $table->text('user_id');
            $table->time('valid_till', 0);
            $table->integer('expires_in');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ig_auth_datas');
    }
}

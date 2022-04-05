<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpsosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('upsos', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('upso_type_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('isPremium')->default(false);
            $table->unsignedBigInteger('region_id');
            $table->integer('show_order')->default(3);  //  1-공지 2-프리미엄 3-상위고정 4-이벤트 5-일반
            $table->string('thumb_path')->nullable();
            $table->string('op_hour')->nullable();
            $table->string('phone')->nullable();
            $table->string('description')->nullable();
            $table->string('title');
            $table->longText('content');
            $table->string('site_name')->nullable();
            $table->string('site_url')->nullable();
            $table->string('site_phone')->nullable();
            $table->integer('visits')->default(0);
            $table->string('status')->default('Active'); // Active / Hold / AdminDeleted / UserDeleted
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upsos');
    }
}

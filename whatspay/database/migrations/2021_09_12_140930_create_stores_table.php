<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            // $table->integer('user_id')->default(0);
            $table->string('store_logo', 400)->nullable();
            $table->string('store_name', 400)->nullable();
            $table->string('whatsapp_num', 20)->nullable();
            $table->string('whatsapp_username', 50)->nullable();
            $table->string('whatsapp_password', 50)->nullable();
            $table->string('business_url', 100)->nullable();
            $table->integer('industry_id')->default(0);
            $table->string('industry_types', 50)->nullable();
            $table->text('description')->nullable();
            $table->text('images')->nullable();
            $table->string('email', 100)->nullable();
            $table->string('website', 100)->nullable();
            $table->string('street_address', 256)->nullable();
            $table->string('latitude', 12)->nullable();
            $table->string('longitude', 12)->nullable();
            $table->string('country', 60)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('postal_code', 14)->nullable();
            $table->string('bank_phone', 16)->nullable();
            $table->string('payment_method', 20)->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
        Schema::table('users', function (Blueprint $table): void {
            $table->dropSoftDeletes();
        });
    }
}

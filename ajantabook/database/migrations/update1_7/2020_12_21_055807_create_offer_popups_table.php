<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferPopupsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('offer_popups')) {
            Schema::create('offer_popups', function (Blueprint $table): void {
                $table->id();
                $table->integer('enable_popup')->default('0')->unsigned();
                $table->string('image')->nullable();
                $table->string('heading');
                $table->string('heading_color')->nullable();
                $table->string('subheading');
                $table->string('subheading_color');
                $table->string('description')->nullable();
                $table->string('description_text_color')->nullable();
                $table->integer('enable_button')->default('0')->unsigned();
                $table->string('button_text')->nullable();
                $table->longText('button_link')->nullable();
                $table->string('button_text_color')->nullable();
                $table->string('button_color')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_popups');
    }
}

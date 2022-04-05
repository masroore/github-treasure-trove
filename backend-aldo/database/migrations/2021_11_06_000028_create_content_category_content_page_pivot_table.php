<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentCategoryContentPagePivotTable extends Migration
{
    public function up(): void
    {
        Schema::create('content_category_content_page', function (Blueprint $table): void {
            $table->unsignedBigInteger('content_page_id');
            $table->foreign('content_page_id', 'content_page_id_fk_5276147')->references('id')->on('content_pages')->onDelete('cascade');
            $table->unsignedBigInteger('content_category_id');
            $table->foreign('content_category_id', 'content_category_id_fk_5276147')->references('id')->on('content_categories')->onDelete('cascade');
        });
    }
}
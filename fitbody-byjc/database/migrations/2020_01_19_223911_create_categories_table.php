<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->string('image')->default('images/avatars/default_pic.jpg');
            $table->integer('parent_id')->unsigned();
            $table->string('group')->nullable();
            $table->boolean('single_page')->default(false); // ako je 1 mora imati url(link) i ponaša se kao SinglePage (ima svoj tekst), ako je 0 nema link nego je kategorija koja ima svoje podstranice...
            $table->string('lang_code')->default('hr');
            $table->boolean('top')->default(false);
            $table->integer('column')->unsigned()->default(1);
            $table->integer('sort_order')->unsigned()->default(0);
            $table->boolean('status')->default(false);
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrlAliasesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('url_aliases', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('source')->index();
            $table->string('alias')->unique();
            $table->string('locale')->nullable();

            $table->string('type', 5)->nullable(); // null - is alias | 301 | 302
            $table->string('model_type')->nullable();
            $table->integer('model_id')->nullable();

            $table->index(['source', 'locale']);
            $table->unique(['alias', 'locale']);
            $table->unique(['model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('url_aliases');
    }
}

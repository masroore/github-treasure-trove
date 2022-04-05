<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxonomiesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->createVocabulariesTable();

        $this->createTermsTable();

        $this->createVocabulariablesTable();

        $this->createTermablesTable();
    }

    /**
     * Taxonomy vocabularies table.
     */
    public function createVocabulariesTable(): void
    {
        Schema::create('vocabularies', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('system_name')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('options')->nullable(); // optional, if needed
        });
    }

    /**
     * Taxonomy terms table.
     */
    public function createTermsTable(): void
    {
        Schema::create('terms', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('name');
            $table->string('system_name')->nullable()->unique(); // optional
            $table->text('description')->nullable();

            // Nested https://github.com/lazychaser/laravel-nestedset - $table->nestedSet();
            $table->unsignedInteger('_lft')->default(0);
            $table->unsignedInteger('_rgt')->default(0);
            $table->unsignedInteger('parent_id')->nullable();

            $table->integer('weight')->default(0);
            $table->string('vocabulary');
            $table->boolean('publish')->default(true);
            $table->boolean('safe')->default(false);
            $table->json('options')->nullable(); // optional, if needed
            $table->timestamps();
        });
    }

    /**
     * Таблица сущностей "привязанных" к словарям
     */
    public function createVocabulariablesTable(): void
    {
        Schema::create('vocabularyables', function (Blueprint $table): void {
            $table->unsignedInteger('vocabulary_id');
            $table->morphs('vocabularyable');

            $table->foreign('vocabulary_id')
                ->references('id')
                ->on('vocabularies')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Таблица сущностей "привязанных" к термам
     */
    public function createTermablesTable(): void
    {
        Schema::create('termables', function (Blueprint $table): void {
            $table->unsignedInteger('term_id');
            $table->morphs('termable');

            $table->foreign('term_id')
                ->references('id')
                ->on('terms')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('termables');
        Schema::dropIfExists('vocabularyables');
        Schema::dropIfExists('terms');
        Schema::dropIfExists('vocabularies');
    }
}

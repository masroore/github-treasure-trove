
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelectedLanguageTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('selected_languages', function (Blueprint $table): void {
            $table->id();
            $table->string('language_name')->nullable();
            $table->string('native')->nullable();
            $table->unsignedBigInteger('lang_id')->nullable();
            $table->string('language_universal')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selected_languages');
    }
}

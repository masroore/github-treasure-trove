<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Setup\Entities\IntroPrefix;

class CreateIntroPrefixTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('intro_prefix', function (Blueprint $table): void {
            $table->id();
            $table->string('prefix');
            $table->string('title');
            $table->timestamps();
        });

        IntroPrefix::create(['prefix' => 'PO', 'title' => 'About purchase order']);
        IntroPrefix::create(['prefix' => 'PI', 'title' => 'About purchase invoice']);
        IntroPrefix::create(['prefix' => 'INV', 'title' => 'About sales invoice']);
        IntroPrefix::create(['prefix' => 'QTA', 'title' => 'About customer quotation']);
        IntroPrefix::create(['prefix' => 'RET', 'title' => 'About Retailer']);
        IntroPrefix::create(['prefix' => 'CUS', 'title' => 'About Customer']);
        IntroPrefix::create(['prefix' => 'SUP', 'title' => 'About Supplier']);
        IntroPrefix::create(['prefix' => 'EMP', 'title' => 'About Staff']);
        IntroPrefix::create(['prefix' => 'PSO', 'title' => 'About Packing']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intro_prefix');
    }
}

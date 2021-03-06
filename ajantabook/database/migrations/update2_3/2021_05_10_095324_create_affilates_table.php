<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffilatesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('affilates')) {
            Schema::create('affilates', function (Blueprint $table): void {
                $table->id();
                $table->integer('code_limit');
                $table->longText('about_system')->nullable();
                $table->integer('enable_affilate')->default(0);
                $table->double('refer_amount')->default(0);
                $table->integer('enable_purchase')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affilates');
    }
}

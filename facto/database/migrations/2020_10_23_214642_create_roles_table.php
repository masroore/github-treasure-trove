<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        return false;
        // Schema::dropIfExists('roles');

        Schema::create('roles', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('name')->unique(); // edit posts
            $table->string('label')->nullable();
            $table->boolean('isAdminRole')->default(false);
            // $table->integer('grade')->default( 1 );
            // $table->boolean('isLevelNeedsRole')->default( false );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
}

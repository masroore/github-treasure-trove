<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminPermissionModulesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_permission_modules', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('name', 255)->nullable()->default(null);
            $table->boolean('status')->nullable()->default(1);
            $table->tinyInteger('order_by')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_permission_modules');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminPermissionReferencesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_permission_references', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('permission_modules_id')->unsigned()->nullable()->default(null);
            $table->string('code', 191)->nullable()->default(null)->index();
            $table->string('short_desc', 255)->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->timestamps();
            $table->foreign('permission_modules_id', 'pm_id')
                ->references('id')->on('admin_permission_modules')
                ->onDelete('cascade')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_permission_references');
    }
}

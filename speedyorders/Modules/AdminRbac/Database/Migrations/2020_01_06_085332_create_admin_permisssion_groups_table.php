<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminPermisssionGroupsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_permission_groups', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('group_id')->unsigned()->nullable()->default(null)->index();
            $table->integer('permission_reference_id')->unsigned()->nullable()->default(null)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_permission_groups');
    }
}

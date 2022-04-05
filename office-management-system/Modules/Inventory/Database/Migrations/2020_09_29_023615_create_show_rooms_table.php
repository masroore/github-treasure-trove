<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Account\Entities\ChartAccount;
use Modules\Inventory\Entities\ShowRoom;

class CreateShowRoomsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('show_rooms', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->tinyInteger('status')->default('1');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->on('users')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->on('users')->references('id')->onDelete('cascade');
            $table->timestamps();
        });

        $warehouse = ShowRoom::create([
            'name' => 'Main Branch',
        ]);

        $chart_account = new ChartAccount();
        $chart_account->level = 2;
        $chart_account->is_group = 0;
        $chart_account->name = $warehouse->name . '(Cash)';
        $chart_account->description = null;
        $chart_account->configuration_group_id = 1;
        $chart_account->status = 1;
        $chart_account->parent_id = 1;
        $chart_account->type = 1;
        $chart_account->contactable_type = get_class($warehouse);
        $chart_account->contactable_id = $warehouse->id;
        $chart_account->save();
        ChartAccount::findOrFail($chart_account->id)->update(['code' => '0' . $chart_account->type . '-0' . $chart_account->parent_id . '-' . $chart_account->id]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('show_rooms');
    }
}

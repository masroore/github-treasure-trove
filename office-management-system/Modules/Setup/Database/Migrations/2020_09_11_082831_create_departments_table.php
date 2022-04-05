<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Setup\Entities\Department;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('details')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Department::insert([
            [
                'name' => 'Sales',
                'details' => 'Sales Department',
                'status' => true,
            ],
            [
                'name' => 'Marketing',
                'details' => 'Marketing Department',
                'status' => true,
            ],
            [
                'name' => 'HR',
                'details' => 'HR Department',
                'status' => true,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
}

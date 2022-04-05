<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRolePermissionTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_permission', function (Blueprint $table): void {
            $table->id();
            $table->integer('permission_id')->nullable();
            $table->integer('role_id')->nullable()->unsigned();
            $table->boolean('status')->default(1);
            $table->integer('created_by')->default(1)->unsigned();
            $table->integer('updated_by')->default(1)->unsigned();
            $table->timestamps();
        });

        DB::statement('INSERT INTO `role_permission` (`id`, `permission_id`, `role_id`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
        (1, 170, 3, 1, 1, 1, NULL, NULL),
        (2, 171, 3, 1, 1, 1, NULL, NULL),
        (3, 325, 3, 1, 1, 1, NULL, NULL),
        (4, 177, 3, 1, 1, 1, NULL, NULL),
        (5, 193, 3, 1, 1, 1, NULL, NULL),
        (6, 194, 3, 1, 1, 1, NULL, NULL),
        (7, 338, 3, 1, 1, 1, NULL, NULL),
        (8, 339, 3, 1, 1, 1, NULL, NULL),
        (9, 217, 3, 1, 1, 1, NULL, NULL),
        (10, 218, 3, 1, 1, 1, NULL, NULL),
        (11, 219, 3, 1, 1, 1, NULL, NULL),
        (12, 220, 3, 1, 1, 1, NULL, NULL),
        (13, 221, 3, 1, 1, 1, NULL, NULL),
        (14, 222, 3, 1, 1, 1, NULL, NULL),
        (15, 223, 3, 1, 1, 1, NULL, NULL),
        (16, 224, 3, 1, 1, 1, NULL, NULL),
        (17, 225, 3, 1, 1, 1, NULL, NULL),
        (18, 226, 3, 1, 1, 1, NULL, NULL),
        (19, 227, 3, 1, 1, 1, NULL, NULL),
        (20, 228, 3, 1, 1, 1, NULL, NULL),
        (21, 229, 3, 1, 1, 1, NULL, NULL),
        (22, 230, 3, 1, 1, 1, NULL, NULL),
        (23, 342, 3, 1, 1, 1, NULL, NULL),
        (24, 343, 3, 1, 1, 1, NULL, NULL),
        (25, 344, 3, 1, 1, 1, NULL, NULL),
        (26, 231, 3, 1, 1, 1, NULL, NULL),
        (27, 232, 3, 1, 1, 1, NULL, NULL),
        (28, 320, 3, 1, 1, 1, NULL, NULL),
        (29, 321, 3, 1, 1, 1, NULL, NULL),
        (30, 233, 3, 1, 1, 1, NULL, NULL),
        (31, 234, 3, 1, 1, 1, NULL, NULL),
        (32, 235, 3, 1, 1, 1, NULL, NULL),
        (33, 236, 3, 1, 1, 1, NULL, NULL),
        (34, 237, 3, 1, 1, 1, NULL, NULL),
        (35, 341, 3, 1, 1, 1, NULL, NULL),
        (36, 289, 3, 1, 1, 1, NULL, NULL),
        (37, 290, 3, 1, 1, 1, NULL, NULL),
        (38, 291, 3, 1, 1, 1, NULL, NULL),
        (39, 292, 3, 1, 1, 1, NULL, NULL),
        (40, 293, 3, 1, 1, 1, NULL, NULL),
        (41, 294, 3, 1, 1, 1, NULL, NULL),
        (42, 261, 3, 1, 1, 1, NULL, NULL),
        (43, 262, 3, 1, 1, 1, NULL, NULL),
        (44, 263, 3, 1, 1, 1, NULL, NULL),
        (45, 239, 3, 1, 1, 1, NULL, NULL),
        (46, 315, 3, 1, 1, 1, NULL, NULL),
        (47, 316, 3, 1, 1, 1, NULL, NULL),
        (48, 317, 3, 1, 1, 1, NULL, NULL),
        (49, 800, 3, 1, 1, 1, NULL, NULL)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission');
    }
}

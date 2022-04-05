<?php

use App\Models\Course;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEvaluationType extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table): void {
            $table->integer('evaluation_type_id')
                ->references('id')->on('evaluation_types')
                ->onDelete('restrict')
                ->after('color')
                ->nullable();
        });

        // We need to migrate the old course_evaluation_type contents to this new format.
        foreach (DB::table('course_evaluation_type')->get() as $course_eval) {
            Course::find($course_eval->course_id)->update(['evaluation_type_id' => $course_eval->evaluation_type_id]);
        }

        // then, you can delete the course_evaluation_type table

        // You also need to create new evaluation types to reconstruct former courses skills and gradetypes associations.
        // then you can delete course_grade_type manually

        // same process for skills
        // then you can delete course_skill manually
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
}

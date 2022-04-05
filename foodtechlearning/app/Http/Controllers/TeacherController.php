<?php

namespace App\Http\Controllers;

use App\Models\Course;

class TeacherController extends Controller
{
    public function delete_course(Course $course)
    {
        if ($course->user_id !== auth()->id()) {
            abort(403);
        }
        $course->delete();
        session()->flash('flash_message', 'Course deleted successfully.');

        return redirect()->route('teacher.courses');
    }

    public function restore_course($course)
    {
        $course = Course::withTrashed()->findOrFail($course);
        if ($course->user_id !== auth()->id()) {
            abort(403);
        }
        $course->restore();
        session()->flash('flash_message', 'Course restored successfully.');

        return redirect()->route('teacher.courses');
    }

    public function force_delete_course($course)
    {
        $course = Course::withTrashed()->findOrFail($course);
        if ($course->user_id !== auth()->id()) {
            abort(403);
        }
        $course->forceDelete();
        session()->flash('flash_message', 'Course deleted permanently.');

        return redirect()->route('teacher.courses.deleted');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Spatie\MediaLibrary\Support\MediaStream;

class MiscellaneousController extends Controller
{
    public function home()
    {
        switch (auth()->user()?->default_role?->name) {
            case 'student':
                return redirect()->route('student.courses');

                break;
            case 'teacher':
                return redirect()->route('teacher.courses');

                break;
        }
        abort(404);
    }

    public function download_attachments(Lesson $lesson)
    {
        return MediaStream::create($lesson->course->name . ' - ' . $lesson->name . '-attachments.zip')->addMedia($lesson->getMedia());
    }
}

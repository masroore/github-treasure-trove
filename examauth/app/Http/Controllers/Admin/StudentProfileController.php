<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyStudentProfileRequest;
use App\Http\Requests\StoreStudentProfileRequest;
use App\Http\Requests\UpdateStudentProfileRequest;
use App\Models\Course;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Semester;
use App\Models\Session;
use App\Models\StudentProfile;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class StudentProfileController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('student_profile_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentProfiles = StudentProfile::with(['faculty', 'department', 'media'])->get();

        return view('admin.studentProfiles.index', compact('studentProfiles'));
    }

    public function create()
    {
        abort_if(Gate::denies('student_profile_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faculties = Faculty::pluck('falculty_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.studentProfiles.create', compact('faculties', 'departments'));
    }

    public function store(StoreStudentProfileRequest $request)
    {
        $studentProfile = StudentProfile::create($request->all());

        if ($request->input('passport', false)) {
            $studentProfile->addMedia(storage_path('tmp/uploads/' . basename($request->input('passport'))))->toMediaCollection('passport');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $studentProfile->id]);
        }

        return redirect()->route('admin.student-profiles.index');
    }

    public function edit(StudentProfile $studentProfile)
    {
        abort_if(Gate::denies('student_profile_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faculties = Faculty::pluck('falculty_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $studentProfile->load('faculty', 'department');

        return view('admin.studentProfiles.edit', compact('faculties', 'departments', 'studentProfile'));
    }

    public function update(UpdateStudentProfileRequest $request, StudentProfile $studentProfile)
    {
        $studentProfile->update($request->all());

        if ($request->input('passport', false)) {
            if (!$studentProfile->passport || $request->input('passport') !== $studentProfile->passport->file_name) {
                if ($studentProfile->passport) {
                    $studentProfile->passport->delete();
                }
                $studentProfile->addMedia(storage_path('tmp/uploads/' . basename($request->input('passport'))))->toMediaCollection('passport');
            }
        } elseif ($studentProfile->passport) {
            $studentProfile->passport->delete();
        }

        return redirect()->route('admin.student-profiles.index');
    }

    public function show(StudentProfile $studentProfile)
    {
        abort_if(Gate::denies('student_profile_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentProfile->load('faculty', 'department');

        return view('admin.studentProfiles.show', compact('studentProfile'));
    }

    public function destroy(StudentProfile $studentProfile)
    {
        abort_if(Gate::denies('student_profile_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentProfile->delete();

        return back();
    }

    public function massDestroy(MassDestroyStudentProfileRequest $request)
    {
        StudentProfile::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('student_profile_create') && Gate::denies('student_profile_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new StudentProfile();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function check_status(Request $request)
    {
        $course_id = $request->course_id;
        $course = Course::find($request->course_id);
        $dept = Department::where('id', $course->department_id)->first();
        $faculty = Faculty::where('id', $dept->faculty_id)->first();
        $lecturer = User::where('id', $course->course_lecturer_id)->first();

        return view('admin.studentStatusChecks.details', compact('dept', 'lecturer', 'faculty', 'course'));
    }

    public function confirm(Request $request)
    {
        abort_if(Gate::denies('student_profile_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course_id = $request->course_id;
        $course = Course::find($course_id);

        $studentProfiles = StudentProfile::where('level', $course->level)->with(['faculty', 'department', 'media'])->get();

        return view('admin.studentStatusChecks.eligible', compact('studentProfiles', 'course'));
    }

    public function eligible()
    {
        $id = $_GET['id'];
        $studentProfile = StudentProfile::find($id);

        return view('admin.studentStatusChecks.check-details', compact('studentProfile'));
    }

    public function exam_eligible()
    {
        $session = Session::find(1);
        $semester = Semester::find(1);

        $id = $_GET['id'];
        $studentProfile = StudentProfile::find($id);

        $studentProfile->confirm = 'Confirmed';
        $studentProfile->save();

        return redirect()->back();
    }
}

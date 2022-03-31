<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyStudentStatusCheckRequest;
use App\Http\Requests\StoreStudentStatusCheckRequest;
use App\Http\Requests\UpdateStudentStatusCheckRequest;
use App\Models\Course;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class StudentStatusCheckController extends Controller
{
    public function index()
    {
        $courses = Course::pluck('course_code', 'id')->prepend('Please select a course code', '');

        abort_if(Gate::denies('student_status_check_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.studentStatusChecks.index', compact('courses'));
    }

    public function create()
    {
        abort_if(Gate::denies('student_status_check_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.studentStatusChecks.create');
    }

    public function store(StoreStudentStatusCheckRequest $request)
    {
        return 1;
    }

    public function edit(StudentStatusCheck $studentStatusCheck)
    {
        abort_if(Gate::denies('student_status_check_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.studentStatusChecks.edit', compact('studentStatusCheck'));
    }

    public function update(UpdateStudentStatusCheckRequest $request, StudentStatusCheck $studentStatusCheck)
    {
        $studentStatusCheck->update($request->all());

        return redirect()->route('admin.student-status-checks.index');
    }

    public function show(StudentStatusCheck $studentStatusCheck)
    {
        abort_if(Gate::denies('student_status_check_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.studentStatusChecks.show', compact('studentStatusCheck'));
    }

    public function destroy(StudentStatusCheck $studentStatusCheck)
    {
        abort_if(Gate::denies('student_status_check_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentStatusCheck->delete();

        return back();
    }

    public function massDestroy(MassDestroyStudentStatusCheckRequest $request)
    {
        StudentStatusCheck::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

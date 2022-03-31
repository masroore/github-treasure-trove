@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ $studentProfile->student_name }}'s Details
    </div>

    <div class="card-body">
        <div class="form-group">
            {{-- <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.student-profiles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> --}}
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.studentProfile.fields.id') }}
                        </th>
                        <td>
                            {{ $studentProfile->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentProfile.fields.student_name') }}
                        </th>
                        <td>
                            {{ $studentProfile->student_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentProfile.fields.matric_number') }}
                        </th>
                        <td>
                            {{ $studentProfile->matric_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentProfile.fields.gender') }}
                        </th>
                        <td>
                            {{ App\Models\StudentProfile::GENDER_SELECT[$studentProfile->gender] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentProfile.fields.faculty') }}
                        </th>
                        <td>
                            {{ $studentProfile->faculty->falculty_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentProfile.fields.department') }}
                        </th>
                        <td>
                            {{ $studentProfile->department->department_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentProfile.fields.level') }}
                        </th>
                        <td>
                            {{ App\Models\StudentProfile::LEVEL_SELECT[$studentProfile->level] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Exam Status
                        </th>
                        <td>
                            {{ $studentProfile->confirm ?? 'Not Confirmed' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.studentProfile.fields.passport') }}
                        </th>
                        <td>
                            @if($studentProfile->passport)
                                <a href="{{ $studentProfile->passport->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $studentProfile->passport->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-primary" href="{{ route('admin.exam_eligible', $studentProfile->id) }}&id={{ $studentProfile->id }}">
                    Confirm For This Exam
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
@extends('layouts.app_task', ['title' => $task->name])

@push('css_before')


@endpush

@section('content')
<task-details task_id="{{ $task->uuid }}"/>
</div>
@endsection


@push('js_before')
    <script src="{{ asset('public/js/app.js') }}"></script>
    <script src="{{ asset('public/js/plugin.js') }}"></script>
@endpush


<div>
    <div class="mb-6 p-4 bg-white shadow-lg">
        <a href="{{ route('teacher.courses.create') }}" class="inline-block button-primary"><x-gmdi-dashboard-customize-r /> Create a new course</a>
        <a href="{{ route('teacher.courses.deleted') }}" class="inline-block button-primary hover:bg-primary-500 bg-secondary-500 text-gray-900"><x-gmdi-restore-from-trash-r /> View deleted courses</a>
    </div>
    <ul class="grid-list">
        @forelse ($courses as $course)
            <x-classes.course-item :course="$course"/>
        @empty
        <h3 class="title col-span-4 my-10 md:text-2xl text-center">No courses found. Create one now.</h3>
        @endforelse
    </ul>
</div>

@section('page_title')
    Teacher Courses
@endsection

@section('title')
    Courses
@endsection

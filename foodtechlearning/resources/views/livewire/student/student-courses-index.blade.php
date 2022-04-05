<div>
    <div class="mb-6 p-4 bg-white shadow-lg">
        <h3 class="title-sm">Currently enrolled in {{ $courses->count() }} course/s.</h3>
    </div>
    <ul class="grid-list">
        @forelse ($courses as $course)
            <li class="col-span-1 bg-white rounded-lg shadow divide-y divide-gray-200">
                <div class="w-full flex items-center justify-between p-6 space-x-6">
                    <div class="flex-1 truncate">
                        <div class="flex items-center space-x-3">
                            <h3 class="text-gray-900 text-sm font-medium truncate">{{ $course->name }}</h3>
                            <span class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 text-xs font-medium bg-green-100 rounded-full">{{ $course->code }}</span>
                        </div>
                        <p class="mt-1 text-gray-500 text-sm truncate">Section: {{ $course->section_code }}</p>
                    </div>
                    <img class="w-10 h-10 bg-gray-300 rounded-full flex-shrink-0" src="{{ uiavatar($course->name) }}" alt="">
                </div>
                <div>
                    <div class="-mt-px flex divide-x divide-gray-200">
                        <div class="w-0 flex-1 flex">
                            <a href="{{ route('student.course.lessons', ['course' => $course]) }}" class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                <!-- Heroicon name: solid/mail -->
                                <x-gmdi-sticky-note-2-r class="text-gray-400"/>
                                <span class="ml-3">Lessons</span>
                            </a>
                        </div>
                        <div class="-ml-px w-0 flex-1 flex">
                            <a href="{{ route('student.course.tasks',['course' => $course]) }}" class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
                                <!-- Heroicon name: solid/phone -->
                                <x-gmdi-table-chart-r class="text-gray-400"/>
                                <span class="ml-3">Tasks</span>
                            </a>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <h3 class="title col-span-4 my-10 md:text-2xl text-center">No courses found. Create one now.</h3>
        @endforelse
    </ul>
</div>

@section('page_title')
    Student Courses
@endsection

@section('title')
    Courses
@endsection

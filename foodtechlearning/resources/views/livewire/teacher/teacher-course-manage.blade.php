@section('page_title')
    Manage Course > {{ $course->name }}
@endsection

@section('title')
    Managing {{ $course->code }}
@endsection

<div>
    <x-course-description :course="$course">
        <div class="flex items-center mt-4 space-x-2">
            <a href="{{ route('teacher.course.students', ['editing' => true, 'course' => $course]) }}"
               class="button-primary">Manage Students</a>
            <a href="{{ route('teacher.tasks.index', ['course' => $course]) }}"
               class="bg-green-600 button-primary hover:bg-green-400">View Tasks</a>
        </div>
        <div class="flex items-center mt-4 space-x-2">
            <a href="{{ route('videocall', ['room' => $course->videocall_room]) }}"
               class="button-primary">Go to Videochat Room</a>
            <a href="{{ route('teacher.course.roll_call', ['course' => $course]) }}"
               class="button-danger">Roll Call</a>
            @if (!$course->chatroom)
                <button wire:click="create_chatroom"
                        class="bg-green-600 button-primary hover:bg-green-400">Create Chatroom</button>
            @endif
        </div>
        <div class="flex items-center mt-2 space-x-2">
            <a href="{{ route('teacher.courses.create', ['editing' => true, 'course' => $course]) }}"
               class="button-primary">Edit Course</a>
            <x-form-button :action="route('teacher.course.delete', $course)"
                           method="DELETE"
                           class="button-danger">
                Delete Course
            </x-form-button>
        </div>
    </x-course-description>
    <div class="p-4 mt-4 bg-white outline-primary">
        <div class="flex items-center justify-between">
            <h5 class="title">Lessons</h5>
            <div>
                <a href="{{ route('teacher.lessons.create', ['course' => $course]) }}"
                   class="button-primary">Create Lesson</a>
                <a href="{{ route('teacher.tasks.create', ['course' => $course]) }}"
                   class="button-primary">Create Task</a>
            </div>
        </div>
        <hr class="my-2 border-2 border-primary-600">
        <div class="mt-4">
            <ul class="grid-list">
                @forelse ($lessons as $lesson)
                    <li class="col-span-1 bg-white border divide-y divide-gray-200 rounded-lg shadow">
                        <div class="flex items-center justify-between w-full p-6 space-x-6">
                            <div class="flex-1 truncate">
                                <div class="flex items-center space-x-3">
                                    <h3 class="text-sm font-medium text-gray-900 truncate">{{ $lesson->name }}</h3>
                                    <span class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 text-xs font-medium bg-green-100 rounded-full">{{ $lesson->getMedia()->count() }} attachments</span>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 truncate">Date Created: {{ $lesson->readable_date_created }}</p>
                                <h5 class="title-sm">Status: {{ $lesson->status }}</h5>
                            </div>
                            <img class="flex-shrink-0 w-10 h-10 bg-gray-300 rounded-full"
                                 src="{{ uiavatar($lesson->name) }}"
                                 alt="lesson image">
                        </div>
                        <div>
                            <div class="flex -mt-px divide-x divide-gray-200">
                                <div class="flex flex-1 w-0">
                                    <a href="{{ route('teacher.lesson.manage', ['lesson' => $lesson]) }}"
                                       class="relative inline-flex items-center justify-center flex-1 w-0 py-4 text-sm font-medium text-gray-700 border border-transparent rounded-br-lg hover:text-gray-500">
                                        <!-- Heroicon name: solid/phone -->
                                        <x-gmdi-table-chart-r class="text-gray-400" />
                                        <span class="ml-3">View</span>
                                    </a>
                                </div>
                                <div class="flex flex-1 w-0 -ml-px">
                                    <a href="{{ route('teacher.lessons.create', ['course' => $course, 'lesson' => $lesson, 'editing' => true]) }}"
                                       class="relative inline-flex items-center justify-center flex-1 w-0 py-4 -mr-px text-sm font-medium text-gray-700 border border-transparent rounded-bl-lg hover:text-gray-500">
                                        <!-- Heroicon name: solid/mail -->
                                        <x-gmdi-edit-r class="text-gray-400" />
                                        <span class="ml-3">Edit</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <h3 class="col-span-4 my-10 text-center title md:text-2xl">No lessons found. Create one now.</h3>
                @endforelse
            </ul>
        </div>
    </div>
</div>

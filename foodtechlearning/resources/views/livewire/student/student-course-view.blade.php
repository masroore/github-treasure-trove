@section('page_title')
    View Course > {{ $course->name }}
@endsection

@section('title')
    Viewing {{ $course->code }}
@endsection

<div>
    <x-course-description :course="$course">
        <h3 class="title-sm">Instructor: {{ $course->teacher->name }}</h3>
        <h3 class="title-sm">{{ $lessons->count() }} lessons uploaded</h3>
        <a href="{{ route('videocall', ['room' => $course->videocall_room]) }}" class="button-primary">Go to
            Videochat
            Room</a>
    </x-course-description>
    <div class="mt-4">
        <ul class="grid-list">
            @forelse ($lessons as $lesson)
                <li class="col-span-1 bg-white border divide-y divide-gray-200 rounded-lg shadow">
                    <div class="flex items-center justify-between w-full p-6 space-x-6">
                        <div class="flex-1 truncate">
                            <div class="flex items-center space-x-3">
                                <h3 class="text-sm font-medium text-gray-900 truncate">{{ $lesson->name }}</h3>
                                <span
                                    class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 text-xs font-medium bg-green-100 rounded-full">{{ $lesson->getMedia()->count() }}
                                    attachments</span>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 truncate">Date Created:
                                {{ $lesson->readable_date_created }}</p>
                        </div>
                        <img class="flex-shrink-0 w-10 h-10 bg-gray-300 rounded-full"
                            src="{{ uiavatar($lesson->name) }}" alt="">
                    </div>
                    <div>
                        <div class="flex -mt-px divide-x divide-gray-200">
                            @if ($lesson->locked)
                                <div class="flex flex-1 w-0">
                                    <a href="#"
                                        class="relative inline-flex items-center justify-center flex-1 w-0 py-4 text-sm font-medium text-gray-700 border border-transparent rounded-br-lg hover:text-gray-500">
                                        <!-- Heroicon name: solid/phone -->
                                        <x-gmdi-lock-r class="text-gray-400" />
                                        <span class="ml-3">LOCKED</span>
                                    </a>
                                </div>
                            @else
                                <div class="flex flex-1 w-0">
                                    <a href="{{ route('student.lesson.view', ['lesson' => $lesson]) }}"
                                        class="relative inline-flex items-center justify-center flex-1 w-0 py-4 text-sm font-medium text-gray-700 border border-transparent rounded-br-lg hover:text-gray-500">
                                        <!-- Heroicon name: solid/phone -->
                                        <x-gmdi-table-chart-r class="text-gray-400" />
                                        <span class="ml-3">View</span>
                                    </a>
                                </div>
                                <div class="flex flex-1 w-0 -ml-px">
                                    <a href="{{ route('download.attachments', ['lesson' => $lesson, 'editing' => true]) }}"
                                        class="relative inline-flex items-center justify-center flex-1 w-0 py-4 -mr-px text-sm font-medium text-gray-700 border border-transparent rounded-bl-lg hover:text-gray-500">
                                        <!-- Heroicon name: solid/mail -->
                                        <x-gmdi-download-for-offline-r class="text-gray-400" />
                                        <span class="ml-3 text-sm text-center">Download</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </li>
            @empty
                <h3 class="col-span-4 my-10 text-center title md:text-2xl">No lessons created for this course yet.</h3>
            @endforelse
        </ul>
    </div>
</div>

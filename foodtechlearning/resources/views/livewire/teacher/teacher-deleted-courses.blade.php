<div>
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
                        <p class="mt-1 text-gray-500 text-sm truncate">Deleted on: {{ $course->deleted_at }}</p>
                    </div>
                    <img class="w-10 h-10 bg-gray-300 rounded-full flex-shrink-0" src="{{ uiavatar($course->name) }}" alt="">
                </div>
                <div>
                    <div class="-mt-px flex divide-x divide-gray-200">
                        <div class="w-0 flex-1 flex">
                            <form method="POST" action="{{ route('teacher.course.restore', ['course' => $course]) }}" class="relative w-0 flex-1 border border-transparent rounded-br-lg">
                                @csrf
                                <button type="submit" onclick="return confirm('Are you sure?') || event.preventDefault()" class="inline-flex hover:text-gray-500 w-full items-center justify-center py-4 text-sm text-gray-700 font-medium">
                                    <x-gmdi-restore-r class="text-gray-400"/>
                                    <span class="ml-3">Restore</span>
                                </button>
                            </form>
                        </div>
                        <div class="-ml-px w-0 flex-1 flex">
                            <form method="POST" action="{{ route('teacher.course.force_delete', ['course' => $course]) }}" class="relative w-0 flex-1 border border-transparent rounded-br-lg">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?') || event.preventDefault()" class="inline-flex hover:text-gray-500 w-full items-center justify-center py-4 text-sm text-gray-700 font-medium">
                                    <x-gmdi-warning-r class="text-red-600"/>
                                    <span class="ml-3">Delete Forever</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </li>

        @empty
            <h3 class="title col-span-4 my-10 md:text-2xl text-center">No deleted courses found.</h3>
        @endforelse
    </ul>
</div>

@section('page_title')
    Teacher Deleted Courses
@endsection

@section('title')
    Deleted Courses
@endsection

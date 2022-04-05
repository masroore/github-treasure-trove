<article class="text-white">
    <ul class="flex flex-col p-2 space-y-2 font-semibold">
        {{-- <a href="{{ route('teacher.dashboard') }}"> --}}
        {{-- <li class="hover:bg-secondary-500 hover:text-gray-900 rounded-md {{ !Str::contains(request()->route()->uri, 'dashboard') ?: 'text-gray-900 bg-secondary-500' }} p-4"> --}}
        {{-- <x-gmdi-dashboard-r /> Dashboard --}}
        {{-- </li> --}}
        {{-- </a> --}}
        <a href="{{ route('teacher.courses') }}">
            <li
                class="hover:bg-secondary-500 hover:text-gray-900 rounded-md {{ !Str::contains(request()->route()->uri, 'courses') ?: 'text-gray-900 bg-secondary-500' }} p-4">
                <x-gmdi-class-r /> Courses
            </li>
        </a>
        <a href="{{ route('teacher.gradebook') }}">
            <li
                class="hover:bg-secondary-500 hover:text-gray-900 rounded-md {{ !Str::contains(request()->route()->uri, 'gradebook') ?: 'text-gray-900 bg-secondary-500' }} p-4">
                <x-gmdi-table-chart-r /> Gradebook
            </li>
        </a>
        <a href="{{ route('chat') }}">
            <li
                class="hover:bg-secondary-500 hover:text-gray-900 rounded-md {{ !Str::contains(request()->route()->uri, 'chat') ?: 'text-gray-900 bg-secondary-500' }} p-4">
                <x-gmdi-chat-r /> Chat
            </li>
        </a>
    </ul>
</article>

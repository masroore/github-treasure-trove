@section('page_title')
    Tasks for Course > {{ $course->name }}
@endsection

@section('title')
    Tasks for {{ $course->code }}
@endsection

<div class="p-4">
    <div>
        @if ($current_task)
            <div x-data="{preview: false}" x-show="preview" x-cloak @open-task-preview.window="preview = true" class="bg-gray-600 bg-opacity-75 inset-0 fixed flex flex-col justify-center items-center p-4 z-10">
                <div @click.away="preview = false" class="bg-white md:w-1/2 p-4 overflow-y-auto flex-1">
                    <h3 class="title-sm">Task Name: {{ $current_task->name }}</h3>
                    <h3 class="title-sm">Instructions: </h3>
                    <p class="tracking-wider italic px-4 text-sm">{{ $current_task->instructions }}</p>
                    <h3 class="title-sm">Task Deadline: {{ $current_task->readable_deadline }}</h3>
                    <h3 class="title-sm">Highest Score: {{ $current_task->max_score }}/{{ $current_task->max_score }}  pts.</h3>
                @forelse($current_task->questions as $qk => $question)
                        <div class="@error("questions.$qk.*"){{ 'bg-red-200' }}@enderror mt-4 outline-primary p-4">
                            <div class="flex md:flex-row flex-col space-y-2 md:space-y-0 items-center mb-2 justify-between">
                                <h3 class="title">Question {{ $loop->iteration }}. ({{ strtoupper($question['type']) }})</h3>
                                <h3 class="title-sm bg-green-400 text-gray-900 py-1 px-2 rounded-full font-semibold">{{ $question['points'] }} pts.</h3>
                            </div>
                            <p class="whitespace-pre-wrap px-4 tracking-wider italic text-sm">{{ $question['body'] }}</p>
                            @if (count($question['answers']))
                                <div class="my-2">
                                    <h3 class="title-sm">Answers Key</h3>
                                    <ul class="px-4">
                                        @forelse ($question['answers'] as $ak => $answer)
                                            <li class="font-medium text-sm">
                                                <span>&gt; {{ $answer }}</span>
                                            </li>
                                        @empty
                                            <li class="font-medium text-sm">No answers provided.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            @endif
                            @if (count($question['choices']))
                                <div class="my-2">
                                    <h3 class="title-sm">Choices</h3>
                                    <ul class="flex flex-col px-4 space-y-1">
                                        @forelse ($question['choices'] as $ck => $choice)
                                            <h4 class="title-sm">&gt; {{ $choice }}</h4>
                                        @empty
                                            <li class="font-medium text-sm">No choices provided.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            @endif
                            @if ($attachments->where('custom_properties.identifier', $question['identifier'])->count())
                                <div class="my-2">
                                    <h3 class="title-sm">File Attachments</h3>
                                    <ul class="px-4">
                                        @forelse ($attachments->where('custom_properties.identifier', $question['identifier']) as $atk => $attachment)
                                            <a target="_blank" href="{{ $attachment->getUrl() }}">
                                                <li class="font-medium underline text-sm">
                                                    <span class="italic text-green-700">{{ $attachment->name }}</span>
                                                </li>
                                            </a>
                                        @empty
                                            <li class="font-medium text-sm">No files attached.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            @endif
                            @if ($question['file_required'])
                                <h1 class="title-sm">File is required.</h1>
                            @endif
                        </div>
                    @empty
                        <div class="mt-4 outline-primary p-4">
                            <h3 class="title text-center">No questions created.</h3>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif
        <ul class="grid-list">
            @forelse ($tasks as $task)
                <li class="col-span-1 border bg-white rounded-lg shadow divide-y divide-gray-200">
                    <div class="w-full flex items-center justify-between p-6 space-x-6">
                        <div class="flex-1 truncate">
                            <div class="flex items-center space-x-3">
                                <h3 class="text-gray-900 text-sm font-medium truncate">{{ $task->name }}</h3>
                                <span class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 text-xs font-medium bg-green-100 rounded-full">{{ $task->getMedia()->count() }} attachments</span>
                            </div>
                            <p class="mt-1 text-gray-500 text-xs truncate">Date Created: {{ $task->readable_date_created }}</p>
                            <p class="mt-1 text-gray-500 text-xs truncate">Deadline: {{ $task->readable_deadline }}</p>
                        </div>
                        <img class="w-10 h-10 bg-gray-300 rounded-full flex-shrink-0" src="{{ uiavatar($task->name) }}" alt="">
                    </div>
                    <div>
                        <div class="-mt-px flex divide-x divide-gray-200">
                            <div class="w-0 flex-1 flex">
                                <a href="{{ route('teacher.tasks.manage', ['task' => $task]) }}" class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
                                    <!-- Heroicon name: solid/phone -->
                                    <x-gmdi-table-chart-r class="text-gray-400"/>
                                    <span class="ml-3">Manage</span>
                                </a>
                            </div>
                            <div class="-ml-px w-0 flex-1 flex">
                                <button wire:click="preview_task({{$task}})" class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                    <!-- Heroicon name: solid/mail -->
                                    <x-gmdi-view-in-ar-r class="text-gray-400"/>
                                    <span class="ml-3">Preview</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <h3 class="title col-span-4 my-10 md:text-2xl text-center">No tasks found. Create one now.</h3>
            @endforelse
        </ul>
    </div>
</div>

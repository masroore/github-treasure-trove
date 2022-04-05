@section('page_title')
    Tasks for Course > {{ $course->name }}
@endsection

@section('title')
    Tasks for {{ $course->code }}
@endsection

<div class="p-4">
    <div>
        @if ($current_task)
            <div x-data="{preview: false}" x-show="preview" x-cloak @open-task-preview.window="preview = true"
                class="fixed inset-0 z-10 flex flex-col items-center justify-center p-4 bg-gray-600 bg-opacity-75">
                <div @click.away="preview = false" class="flex-1 p-4 overflow-y-auto bg-white md:w-1/2">
                    <h3 class="title-sm">Task Name: {{ $current_task->name }}</h3>
                    <h3 class="title-sm">Instructions: </h3>
                    <p class="px-4 text-sm italic tracking-wider">{{ $current_task->instructions }}</p>
                    <h3 class="title-sm">Task Deadline: {{ $current_task->readable_deadline }}</h3>
                    <h3 class="title-sm">Highest Score:
                        {{ $current_task->max_score }}/{{ $current_task->max_score }} pts.</h3>
                    @forelse($current_task->questions as $qk => $question)
                        <div class="@error(" questions.$qk.*"){{ 'bg-red-200' }}@enderror mt-4 outline-primary
                            p-4">
                            <div
                                class="flex flex-col items-center justify-between mb-2 space-y-2 md:flex-row md:space-y-0">
                                <h3 class="title">Question {{ $loop->iteration }}.
                                    ({{ strtoupper($question['type']) }})</h3>
                                <h3 class="px-2 py-1 font-semibold text-gray-900 bg-green-400 rounded-full title-sm">
                                    {{ $question['points'] }} pts.</h3>
                            </div>
                            <p class="px-4 text-sm italic tracking-wider whitespace-pre-wrap">{{ $question['body'] }}
                            </p>
                            @if ($submission)
                                <div class="my-2">
                                    <h3 class="title-sm">Your Answers</h3>
                                    <ul class="px-4">
                                        @if (is_array(collect($submission->answers)->firstWhere('identifier', $question['identifier'])['answers']))
                                            @forelse (collect($submission->answers)->firstWhere('identifier', $question['identifier'])['answers'] as $ak => $answer)
                                                <li class="text-sm font-medium">
                                                    <span>&gt; {{ $answer }}</span>
                                                </li>
                                            @empty
                                                @if ($submission?->getMedia()->where('custom_properties.identifier', $question['identifier'])->count())
                                                    <li class="text-sm font-medium">File attached.</li>
                                                @else
                                                    <li class="text-sm font-medium">No answers provided.</li>
                                                @endif
                                            @endforelse
                                        @else
                                            @if ($question['type'] === 'essay')
                                                <p class="px-4 text-sm italic tracking-wider whitespace-pre-wrap">
                                                    {{ collect($submission->answers)->firstWhere('identifier', $question['identifier'])['answers'] }}
                                                </p>
                                            @else
                                                <li class="text-sm font-medium">&gt;
                                                    {{ collect($submission->answers)->firstWhere('identifier', $question['identifier'])['answers'] }}
                                                </li>
                                            @endif
                                        @endif

                                    </ul>
                                </div>
                            @endif
                            @if ($submission?->getMedia()->where('custom_properties.identifier', $question['identifier'])->count())
                                <div class="my-2">
                                    <h3 class="title-sm">Your Attachments</h3>
                                    <ul class="px-4">
                                        @forelse ($submission->getMedia()->where('custom_properties.identifier', $question['identifier']) as $fak => $file_attachment)
                                            <a target="_blank" href="{{ $file_attachment->getUrl() }}">
                                                <li class="text-sm font-medium underline">
                                                    <span
                                                        class="italic text-green-700">{{ $file_attachment->name }}</span>
                                                </li>
                                            </a>
                                        @empty
                                            <li class="text-sm font-medium">No attachments provided.</li>
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
                                            <li class="text-sm font-medium">No choices provided.</li>
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
                                                <li class="text-sm font-medium underline">
                                                    <span
                                                        class="italic text-green-700">{{ $attachment->name }}</span>
                                                </li>
                                            </a>
                                        @empty
                                            <li class="text-sm font-medium">No files attached.</li>
                                        @endforelse
                                    </ul>
                                </div>
                            @endif
                            @if ($question['file_required'])
                                <h1 class="title-sm">File is required.</h1>
                            @endif
                        </div>
                        @empty
                            <div class="p-4 mt-4 outline-primary">
                                <h3 class="text-center title">No questions created.</h3>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif
            <ul class="grid-list">
                @forelse ($tasks as $task)
                    <li class="col-span-1 bg-white border divide-y divide-gray-200 rounded-lg shadow">
                        <div class="flex items-center justify-between w-full p-6 space-x-6">
                            <div class="flex-1 truncate">
                                <div class="flex items-center space-x-3">
                                    <h3 class="text-sm font-medium text-gray-900 truncate">{{ $task->name }}</h3>
                                    <span
                                        class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 text-xs font-medium bg-green-100 rounded-full">{{ $task->getMedia()->count() }}
                                        attachments</span>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 truncate">Date Created:
                                    {{ $task->readable_date_created }}</p>
                                <p class="mt-1 text-xs text-gray-500 truncate">Deadline: {{ $task->readable_deadline }}
                                </p>
                            </div>
                            <img class="flex-shrink-0 w-10 h-10 bg-gray-300 rounded-full"
                                src="{{ uiavatar($task->name) }}" alt="">
                        </div>
                        <div>
                            <div class="flex -mt-px divide-x divide-gray-200">
                                <div class="flex flex-1 w-0">
                                    @if ($task->user_submission)
                                        <a href="#"
                                            class="relative inline-flex items-center justify-center flex-1 w-0 py-4 text-sm font-medium text-gray-700 border border-transparent rounded-br-lg hover:text-gray-500">
                                            <!-- Heroicon name: solid/phone -->
                                            @if ($submission?->date_graded)
                                                <span class="ml-3 text-sm underline">Score:
                                                    {{ $submission->score }}/{{ $task->max_score }} pts</span>
                                            @else
                                                <x-gmdi-check-r class="text-gray-400" />
                                                <span class="ml-3">Submitted</span>
                                            @endif
                                        </a>
                                    @else
                                        <a href="{{ route('student.task.answer', ['task' => $task]) }}"
                                            class="relative inline-flex items-center justify-center flex-1 w-0 py-4 text-sm font-medium text-gray-700 border border-transparent rounded-br-lg hover:text-gray-500">
                                            <!-- Heroicon name: solid/phone -->
                                            <x-gmdi-edit-r class="text-gray-400" />
                                            <span class="ml-3">Answer</span>
                                        </a>
                                    @endif
                                </div>
                                <div class="flex flex-1 w-0 -ml-px">
                                    <button wire:click="preview_task({{ $task }})"
                                        class="relative inline-flex items-center justify-center flex-1 w-0 py-4 -mr-px text-sm font-medium text-gray-700 border border-transparent rounded-bl-lg hover:text-gray-500">
                                        <!-- Heroicon name: solid/mail -->
                                        <x-gmdi-view-in-ar-r class="text-gray-400" />
                                        <span class="ml-3">Preview</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <h3 class="col-span-4 my-10 text-center title md:text-2xl">No tasks yet for this course.</h3>
                @endforelse
            </ul>
        </div>
    </div>

@section('page_title')
    Grade Submission > {{ $submission->user->last_name }}
@endsection

@section('title')
    Grading Submission of {{ $submission->user->last_name }}
@endsection
<div class="bg-white md:w-1/2 mx-auto p-4 overflow-y-auto flex-1">
    <h3 class="title-sm">Task Name: {{ $task->name }}</h3>
    <h3 class="title-sm">Instructions: </h3>
    <p class="tracking-wider italic px-4 text-sm">{{ $task->instructions }}</p>
    <h3 class="title-sm">Task Deadline: {{ $task->readable_deadline }}</h3>
    <h3 class="title-sm">Date Submitted: {{ $submission->readable_date_submitted }}</h3>
    <h3 class="title-sm">Highest Score: {{ $task->max_score }}/{{ $task->max_score }}  pts.</h3>
    @forelse($task->questions as $qk => $question)
        <div class="{{ $this->get_class_color($qk) }} mt-4 outline-primary p-4">
            <div>
                <span>
                    <input wire:model="assessment.{{$qk}}.partial" type="number" class="text-xs w-20">
                    <button wire:click="grade_partially({{$qk}})" class="button-primary bg-green-500 hover:bg-green-400">PARTIAL</button>
                </span>
                <button wire:click="grade_as_correct({{$qk}})" class="button-primary bg-green-500 hover:bg-green-400">CORRECT</button>
                <button wire:click="grade_as_incorrect({{$qk}})" class="button-danger">INCORRECT</button>
            </div>
            <x-error field="assessment.{{$qk}}.partial" class="error-xs"/>
            <div class="flex md:flex-row flex-col space-y-2 md:space-y-0 items-center mb-2 justify-between">
                <h3 class="title">Question {{ $loop->iteration }}. ({{ strtoupper($question['type']) }})</h3>
                <h3 class="title-sm bg-green-400 text-gray-900 py-1 px-2 rounded-full font-semibold">{{ $question['points'] }} pts.</h3>
            </div>
            <p class="whitespace-pre-wrap px-4 tracking-wider italic text-sm">{{ $question['body'] }}</p>
            <div class="my-2">
                <h3 class="title-sm">Student Answered</h3>
                <ul class="px-4">
                    @if (is_array(collect($submission->answers)->firstWhere('identifier', $question['identifier'])['answers']))
                        @forelse (collect($submission->answers)->firstWhere('identifier', $question['identifier'])['answers'] as $ak => $answer)
                            <li class="font-medium text-sm">
                                <span>&gt; {{ $answer }}</span>
                            </li>
                        @empty
                            @if ($attachments->where('custom_properties.identifier', $question['identifier'])->count())
                            <li class="font-medium text-sm">File attached.</li>
                            @else
                            <li class="font-medium text-sm">No answers provided.</li>
                            @endif
                        @endforelse
                    @else
                        @if ($question['type'] === 'essay')
                            <p class="italic tracking-wider whitespace-pre-wrap px-4 text-sm">{{ collect($submission->answers)->firstWhere('identifier', $question['identifier'])['answers'] }}</p>
                        @else
                            <li class="font-medium text-sm">&gt; {{ collect($submission->answers)->firstWhere('identifier', $question['identifier'])['answers'] }}</li>
                        @endif
                    @endif

                </ul>
            </div>
            @if ($attachments->where('custom_properties.identifier', $question['identifier'])->count())
                <div class="my-2">
                    <h3 class="title-sm">Student's Attachments</h3>
                    <ul class="px-4">
                        @forelse ($submission->getMedia()->where('custom_properties.identifier', $question['identifier']) as $fak => $file_attachment)
                            <a target="_blank" href="{{ $file_attachment->getUrl() }}">
                                <li class="font-medium underline text-sm">
                                    <span class="italic text-green-700">{{ $file_attachment->name }}</span>
                                </li>
                            </a>
                        @empty
                            <li class="font-medium text-sm">No attachments provided.</li>
                        @endforelse
                    </ul>
                </div>
            @endif
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
    <button wire:click="finish_grading" class="button-primary mt-4">Finish Grading ({{collect($assessment)->sum('score')}}/{{$task->max_score}} pts.)</button>
</div>

@section('page_title')
    Answer Task > {{ $task->name }}
@endsection

@section('title')
    Answering Task
@endsection

<div class="mx-auto md:max-w-5xl">
    <div class="outline-primary @error("*"){{ '!bg-red-200' }}@enderror bg-white z-30 p-4">
        <div class="md:flex-row flex flex-col items-start md:justify-between">
            <div class="w-full">
                <div class="w-full">
                    <h3 class="title-sm">Name:</h3>
                    <h3 class="title-sm">{{ $task->name }}</h3>
                </div>
                <div class="w-full mt-4">
                    <h3 class="title-sm">Instructions:</h3>
                    <p class="text-sm tracking-wider italic px-4">{{ $task->instructions }}</p>
                </div>
                <br>
                <h4 class="title-sm">Deadline:</h4>
                <h4 class="title-sm">{{ $task->readable_deadline }}</h4>
            </div>
            <h3 class="title text-xl bg-primary-600 text-white py-1 px-4 rounded-full font-semibold">{{ strtoupper($task->task_type->name) }}</h3>
        </div>
        <button wire:click="submit_answers" class="button-primary mt-4">SUBMIT ANSWERS</button>
    </div>

    @forelse($questions as $qk => $question)
        <div class="@error("questions.$qk.*"){{ 'bg-red-200' }}@enderror mt-4 outline-primary p-4">
            <div class="flex md:flex-row flex-col space-y-2 md:space-y-0 items-center mb-2 justify-between">
                <div class="flex items-center space-x-1">
                    <h3 class="title">Question {{ $loop->iteration }}.</h3>
                    <h3 class="title-sm bg-green-400 text-gray-900 py-1 px-2 rounded-full font-semibold">{{ strtoupper($question['type']) }}</h3>
                </div>
                <h3 class="title-sm bg-green-400 text-gray-900 py-1 px-2 rounded-full font-semibold">{{ $question['points'] }} pts.</h3>
            </div>
            <x-error field="questions.{{$qk}}.body" class="error-xs"/>
            <p class="whitespace-pre-wrap text-sm tracking-wider italic mb-2">{{ $question['body'] }}</p>
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
            @if ($question['type'] === 'identification')
                <input type="text" wire:model.lazy="answers.{{$qk}}.answers" class="text-sm w-full" placeholder="Your answer...">
            @elseif (in_array($question['type'],['multiple choice', 'true or false']))
                <div class="my-2">
                    <h3 class="title-sm">Choices</h3>
                    <ul class="flex flex-col space-y-1">
                        @forelse ($question['choices'] as $ck => $choice)
                            <label class="cursor-pointer border border-gray-900 p-2 flex items-center space-x-2" for="question_{{$qk}}_choice_{{$ck}}">
                                <input wire:model="answers.{{$qk}}.answers" value="{{$choice}}" type="radio" id="question_{{$qk}}_choice_{{$ck}}"><span class="flex-1">{{$choice}}</span>
                            </label>
                        @empty
                            <li class="font-medium text-sm">No choices provided</li>
                        @endforelse
                    </ul>
                </div>

            @elseif ($question['type'] === 'essay')
                <textarea wire:model.lazy="answers.{{$qk}}.answers" cols="30" rows="4" class="resize-none w-full text-sm" placeholder="Question content..."></textarea>
            @elseif ($question['type'] === 'enumeration')
               <div class="space-y-1">
                   @forelse ($question['answers'] as $ak => $answer)
                       <input type="text" wire:model.lazy="answers.{{$qk}}.answers.{{$ak}}" class="text-sm w-full" placeholder="Your answer...">
                   @empty
                       <li class="font-medium text-sm">No items to answer.</li>
                   @endforelse
               </div>
            @endif
            @if ($question['file_required'])
                <h5 class="title-sm">You are required to submit a file.</h5>
                <div x-data="{show:false}">
                    <button x-show="!show" @click="show=true" class="button-primary">Show Submission Attachments</button>
                    <button x-show="show" x-cloak @click="show=false" class="button-primary">Hide Attachments</button>
                    <div x-show="show" class="mt-1" x-cloak>
                        <x-filepond multiple wire:model="answers.{{$qk}}.attachments"/>
                    </div>
                </div>
            @endif
        </div>
    @empty
        <div class="mt-4 outline-primary p-4">
            <h3 class="title text-center">No questions created.</h3>
        </div>
    @endforelse
</div>

@section('page_title')
    View Lesson > {{ $lesson->name }}
@endsection

@section('title')
    Viewing {{ $lesson->name }}
@endsection


<div>
    <div x-data="{preview: false}" x-show="preview" x-cloak @open-preview.window="preview = true" class="bg-gray-600 bg-opacity-75 inset-0 fixed flex flex-col justify-center items-center p-4 z-10">
        @if (in_array($current_attachment?->type, ['pdf', 'video', 'image']))
            <iframe allowfullscreen src="{{ $current_attachment?->getUrl() }}" @click.away="preview = false" class="bg-white md:w-3/4 p-4 overflow-y-auto flex-1">
            </iframe>
        @else
            <iframe allowfullscreen src="https://drive.google.com/viewer?url={{ $current_attachment?->getUrl() }}&embedded=true" @click.away="preview = false" class="bg-white md:w-3/4 p-4 overflow-y-auto flex-1">
            </iframe>
        @endif

    </div>
    <div class="p-4 bg-white outline-primary">
        <div>
            <h3 class="title-sm">For Course: {{ $lesson->course->name }}</h3>
            <h3 class="title-sm">For Section: {{ $lesson->course->section_code }}</h3>
            <h3 class="title-sm">Lesson Name: {{ $lesson->name }}</h3>
            <h3 class="title-sm">Lesson Description:</h3>
            <p class="tracking-wider px-4 italic text-sm">{{ $lesson->description }}</p>
            <h4 class="title-sm">Date Created: {{ $lesson->readable_date_created }}</h4>
        </div>

    </div>
    <div class="mt-4 md:max-w-5xl mx-auto">
        <h4 class="title">Lesson Attachments</h4>
        <div class="space-y-2">
            @forelse ($attachments as $attachment)
                <div class="outline-primary px-8 !border-green-400 flex flex-col md:flex-row items-center justify-between py-2">
                    <h3>{{ $attachment->name }}</h3>
                    <div class="text-xs">
                        <span class="title-xs">{{ $attachment->human_readable_size }}</span>
                        <span class="title-xs bg-green-300 py-1 px-2 rounded-full">{{ $attachment->extension }}</span>
                        <a href="{{ $attachment->getUrl() }}" download class="text-green-500 rounded-full border p-1 border-green-800 hover:bg-green-200 hover:text-green-700"><x-gmdi-download-for-offline-r />Download</a>
                        <button wire:click="preview_attachment({{$attachment->id}})" class="text-green-500 rounded-full border p-1 border-green-800 hover:bg-green-200 hover:text-green-700"><x-gmdi-remove-red-eye-r />Preview</button>
                    </div>
                </div>
            @empty

            @endforelse
        </div>
        <a href="{{ route('download.attachments', ['lesson' => $lesson]) }}" download class="inline-block button-primary mt-4 px-8"><x-gmdi-download-r/>Download Attachments</a>
    </div>
</div>

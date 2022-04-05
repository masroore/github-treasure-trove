@section('page_title')
    Manage Lesson > {{ $lesson->name }}
@endsection

@section('title')
    Managing {{ $lesson->name }}
@endsection


<div>
    <div class="p-4 bg-white outline-primary">
        <div>
            <h3 class="title-sm">For Course: {{ $lesson->course->name }}</h3>
            <h3 class="title-sm">For Section: {{ $lesson->course->section_code }}</h3>
            <h3 class="title-sm">Lesson Name: {{ $lesson->name }}</h3>
            <h3 class="title-sm">Lesson Description:</h3>
            <p class="tracking-wider px-4 italic text-sm">{{ $lesson->description }}</p>
            <h4 class="title-sm">Date Created: {{ $lesson->readable_date_created }}</h4>
            <h4 class="title-sm">Status: {{ $lesson->status }}</h4>
            <button wire:click="toggle_lesson_status" class="{{ $lesson->locked ? 'button-primary' : 'button-danger' }}">{{ $lesson->locked ? 'Unlock Lesson' : 'Lock Lesson' }}</button>
        </div>

    </div>
    <div class="mt-4">
        <h4 class="title">Lesson Attachments</h4>
        <x-media-library-collection
            name="attachments"
            :model="$lesson"
            collection="default"
        />
        <button wire:click="save" class="button-primary mt-4 px-8">Save</button>
    </div>
</div>

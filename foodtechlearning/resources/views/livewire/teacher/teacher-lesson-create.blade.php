@section('page_title')
    {{$editing ? 'Editing' : 'Create'}} Lesson for Course > {{ $course->name }}
@endsection

@section('title')
    {{$editing ? 'Editing' : 'Creating'}} Lesson for {{ $course->code }}
@endsection

<div class="w-full md:py-8">
    <div class="mx-auto bg-white p-4 max-w-3xl outline-primary">
        <h3>{{ $editing ? 'Edit' :'New' }} Lesson Form</h3>
        <div class="space-y-2 flex flex-col items-start">
            <div class="w-full">
                <input wire:model.defer="name" type="text" class="w-full @error('name'){{'error-outline'}}@enderror text-sm" placeholder="Lesson name...">
                <x-error field="name" class="error-xs" />
            </div>
            <div class="w-full">
                <input wire:model.defer="description" type="text" class="w-full @error('description'){{'error-outline'}}@enderror text-sm" placeholder="Lesson description...">
                <x-error field="description" class="error-xs" />
            </div>
            <button wire:click="save" class="button-primary block">{{ $editing ? 'Save' : 'Create' }}</button>
        </div>
    </div>
</div>

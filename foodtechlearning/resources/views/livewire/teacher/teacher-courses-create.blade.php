<div class="w-full md:py-8">
    <div class="mx-auto bg-white p-4 max-w-3xl outline-primary">
        <h3>{{ $editing ? 'Edit' :'New' }} Course Form</h3>
        <div class="space-y-2 flex flex-col items-start">
            <div class="w-full">
                <label for="name" class="title-sm">Name</label>
                <input wire:model.defer="name" type="text" class="w-full @error('name'){{'error-outline'}}@enderror text-sm" placeholder="Course name...">
                <x-error field="name" class="error-xs" />
            </div>
            <div class="w-full">
                <label for="code" class="title-sm">Code</label>
                <input wire:model.defer="code" type="text" class="w-full @error('code'){{'error-outline'}}@enderror text-sm" placeholder="Course code...">
                <x-error field="code" class="error-xs" />
            </div>
            <div class="w-full">
                <label for="section_code" class="title-sm">Section Code</label>
                <input wire:model.defer="section_code" type="text" class="w-full @error('section_code'){{'error-outline'}}@enderror text-sm" placeholder="Section code...">
                <x-error field="section_code" class="error-xs" />
            </div>
            <button wire:click="save" class="button-primary block">{{ $editing ? 'Save' : 'Create' }}</button>
        </div>
    </div>
</div>

@section('page_title')
    {{ $editing ? "Editing course $course->name" : 'Create new course' }}
@endsection

@section('title')
    {{ $editing ? "Editing course" : 'Creating course' }}
@endsection

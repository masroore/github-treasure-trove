<div>
    <div class="pb-1 border-b border-gray-200 sm:flex sm:items-center sm:justify-between mb-4">
        <h3 id="default" class="text-lg leading-6 font-medium text-gray-900">
            Default
        </h3>
    </div>
    <div class="space-y-6">

        <div class="flex flex-wrap -mx-3">
            <div class="w-full sm:w-1/2 px-3">
                <x-form.text-input wire:model="course.name" name="course.name" label="Name" />
            </div>
            <div class="w-full sm:w-1/2 px-3">
                <x-form.slug-input wire:model="course.slug" />
            </div>
        </div>

        <x-form.text-input wire:model="course.tagline" name="tagline" />

        <x-form.textarea wire:model="course.excerpt" name="excerpt" description="Brief description for the course." />

        <div class="grid grid-cols-5 gap-6">
            <div class="col-span-5 sm:col-span-2">
                <x-form.level wire:model="course.level_code" name="course.level_code" />
            </div>
            <div class="col-span-5 sm:col-span-1">
                <x-form.level-number wire:model="course.level_number" />
            </div>
            <div class="col-span-5 sm:col-span-2">
                <x-form.text-input wire:model="course.level_label" name="course.level_label" label="Level Label" />
            </div>
        </div>

        <div class="grid grid-cols-4 gap-6 flex items-center">
            <div class="col-span-5 sm:col-span-1">
                <x-form.focus wire:model="course.focus" name="course.focus" />
            </div>
            <div class="col-span-5 sm:col-span-2">
                <div class="mt-5 relative flex items-start">
                    <div class="flex items-center h-5">
                        <input id="standby" wire:model="course.standby" name="standby" type="checkbox"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="comments" class="font-medium text-gray-700">Standby</label>
                        <span id="comments-description" class="text-gray-500">
                            sets students to standby upon registration.
                        </span>
                    </div>
                </div>
            </div>

        </div>
        <div class="grid grid-cols-4 gap-6">
            <div class="col-span-5 sm:col-span-1">
                <x-form.city-select wire:model="course.city_id" name="course.city_id" />
            </div>
            <div class="col-span-5 sm:col-span-1">
                <x-form.organization-select wire:model="course.organization_id" name="course.organization_id" />
            </div>
        </div>

    </div>
</div>
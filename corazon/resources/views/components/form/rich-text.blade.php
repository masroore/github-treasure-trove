<div>
    <label for="description" class="block text-sm font-medium text-gray-700 capitalize">
        Description
    </label>
    <div x-data="{ value: @entangle($name) }" x-init="$refs.trix.editor.loadHTML(value)" class="mt-1"
        x-on:trix-change="value = $event.target.value" {{ $attributes->whereDoesntStartWith('wire:model')}} wire:ignore>
        <input id="x" type="hidden" name="content">
        <div class=" w-full">
            <trix-editor input="x" x-ref="trix" class="bg-white border-gray-300 prose"
                style="max-width:100%; height: 350px; overflow-y:auto;">
            </trix-editor>
        </div>
    </div>
</div>
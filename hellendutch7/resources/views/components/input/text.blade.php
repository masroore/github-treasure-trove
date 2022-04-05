<div>
    <label class="block mx-4 pt-2 ">
        <span class="text-gray-700">Page Name</span>
        <input wire:model='name' id='name' type="text" class="form-input mt-1 block w-full" placeholder="Enter the Page name">
        @error('name') <span class="mt-1 text-red-500 text-sm"> {{ $message }}</span> @enderror
    </label>
</div>
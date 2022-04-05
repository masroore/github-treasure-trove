<div class='w-1/3 mt-6'>
    <form wire:submit.prevent="submit" enctype="multipart/form-data">
<div class="form-group">
    <input type="file" class="form-control" wire:model="fileName">
    @error('fileName') <span class="text-danger">{{ $message }}</span> @enderror
</div>
    
        <button type="submit" class="mt-4 bg-indigo-300 btn">Upload</button>
    </form>
</div>

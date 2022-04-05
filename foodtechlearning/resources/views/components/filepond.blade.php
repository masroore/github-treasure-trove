<div wire:ignore class="w-full rounded overflow-hidden border border-gray-900" x-data x-init="
     FilePond.create($refs.fileInput,{
        server:{
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{ $attributes['wire:model'] }}', file, load, error, progress)
                },
                revert: (filename, load) => {
                    @this.removeUpload('{{ $attributes['wire:model'] }}', filename, load)
                }
            }
        })
">
    <input {{ $attributes->whereStartsWith('multiple') }} {{ $attributes->whereStartsWith('required') }} {{ $attributes->whereStartsWith('data') }} x-cloak  x-ref="fileInput" type="file">
</div>

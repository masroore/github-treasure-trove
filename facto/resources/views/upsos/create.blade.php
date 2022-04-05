<x-layout >

    {{-- <script src="/assets/vendor/ckeditor2/ckeditor.js"></script> --}}
    
    {{-- <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script> --}}
    <script src="/assets/vendor/ckeditor2/ckeditor.js"></script>

    <div>
        <x-common.top-title menu='업소정보' mode='신규작성' />
        @livewire('upso-create')
    </div>
</x-layout>


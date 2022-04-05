<x-layout.app>
    <style>
        @import(vendor/spatie/laravel-medialibrary-pro/resources/js/media-library-pro-styles);
    </style>
    <main class="flex flex-wrap  py-4">
        <div class="w-3/5 mx-auto px-2 py-2">
            <form method="POST" enctype="multipart/form-data">
                @csrf

                <div>
                    <input class="" type="file" name="image">
                </div>

                <div>
                    <input class="mt-4 py-2 px-4 rounded-md text-white bg-indigo-600" type="submit">
                </div>
            </form>
        </div>

    </main>

</x-layout.app>
@section('scripts')

@endsection
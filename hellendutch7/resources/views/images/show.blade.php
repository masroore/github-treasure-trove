<x-layout.app>

    <header>

        <div class="flex justify-end w-4/5 mx-auto ">
            <a class="button bg-blue-500 hover:bg-blue-700 text-white mt-8 float-right" href="/product/{{$image->model_id}}">Go Back</a>
        </div>
    </header>
    
    <main class="flex flex-wrap  py-4">
        <div class="w-3/5 mx-auto px-2 py-2">
            <div class="card flex-grow  overflow-hidden">
                <img class="w-full rounded" src="https://{{$image->geturl('full')}}" alt="{{$image->name}}">
            </div>
        </div>

    </main>

</x-layout.app>

@section('scripts')

@endsection
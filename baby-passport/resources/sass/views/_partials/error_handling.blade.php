@if(Session::get($variable))

    <div class="card text-white bg-{{$color}} mb-3">
        <div class="card-body">

            <p class="card-text text-white">
                {{Session::get($variable)}}
            </p>
        </div>
    </div>


@endif



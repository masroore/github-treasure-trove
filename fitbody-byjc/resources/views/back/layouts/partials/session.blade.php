@if(session('success'))
    <div class="alert alert-success alert-dismissable border" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{--<h3 class="alert-heading font-size-h4 font-w400">Session Success</h3>--}}
        <p class="mb-0">{{ session('success') }}</p>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="alert-heading font-size-h4 font-w400">Greška..!</h3>
        <p class="mb-0">{{ session('error') }}</p>
    </div>
@endif
@if(session('warning'))
    <div class="alert alert-warning alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="alert-heading font-size-h4 font-w400">Upozorenje..!</h3>
        <p class="mb-0">{{ session('warning') }}</p>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

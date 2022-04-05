<div class="content-header-left col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12 d-flex align-items-center">
            <h4 class="content-header float-left mb-0 white">
                {{$titleg}}
            </h4>
            <div class="breadcrumb-wrapper col-8">
                <ol class="breadcrumb d-flex align-items-center">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}">
                            <h2 class="m-0"><img src="{{ asset('assets/img/home.png') }}" alt="" class="mr-1"></h2>
                        </a>
                    </li>
                    <li class="active white"><img src="{{ asset('assets/img/flecha.png') }}" alt="" class="mr-1"><a>{{$titleg}}</a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>

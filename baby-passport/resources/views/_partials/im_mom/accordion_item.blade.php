<div class="card mb-2  rounded birth-process">
    <div class="card-header">
        <h1 class="mb-0">
            <button class="btn btn-link text-ce-soir font-weight-bold " type="button" data-toggle="collapse"
                    data-target="#{{$svg}}" aria-expanded="true" aria-controls="{{$svg}}">
                @include('_partials/svg_render',["path"=>$path,"class"=>"mini-process-icon"])
                {{$title}}
            </button>
        </h1>
    </div>

    <div id="{{$svg}}" class="collapse" aria-labelledby="{{$svg}}" data-parent="#accordionExample">
        <div class="card-body text-grey-suit font-weight-bold">
            {!!$copy!!}
        </div>
    </div>
</div>

<div class="card border-0 mt-2">
    <div class="card-header border-purple border-bottom  border-ce-soir mb-3" id="heading{{$termIndex}}">
        <h1 class="mb-0 ">
            <button class="btn btn-link text-ce-soir text-uppercase"
                    type="button"
                    data-toggle="collapse"
                    data-target="#collapse{{$termIndex}}"
                    aria-expanded="{{$termIndex == 0 ?true:false}}"
                    aria-controls="collapse{{$termIndex}}">
                    <i class="fas fa-plus-circle mr-2" style="color:#9A7AA0;"></i> 
                <span class="text-ce-soir"> {{$termTitle}}</span>
            </button>
        </h1>
    </div>

    <div    id="collapse{{$termIndex}}"
            class="collapse {{$termIndex == 0 ?'show':''}}"
            aria-labelledby="heading{{$termIndex}}"
            data-parent="#accordion">

                <div class="card-body text-justify lead text-grey-suit">
                    {!! $termContent!!}
                </div>
    </div>
</div>

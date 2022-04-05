<div class="col-12 col-sm-10 col-md-6  col-xl-4 mt-3">

    <div class="row mx-1  align-items-center">

        <!-- CITY IMAGE -->
        <div class="col-6 p-0">
            <img class="img img-fluid shadow button-border"
                 src="{{asset('storage/cities/'.$city->image)}}"
                 alt="Card image cap">
            <a href="#!">
                <div class="mask rgba-white-slight"></div>
            </a>
        </div>

        <!-- END CITY IMAGE -->


        <!-- CITY CONTENT -->
        <div class="col-6 p-4">


            <h4 class="h4-responsive card-title text-grey-suit mb-1">{{$city->city}}</h4>
            <p class="card-text mb-1">
                @for($i=1;$i<=$city->rating;++$i)
                    <i class="fas fa-star text-spray"></i>
                @endfor
            </p>

            <p class="card-text text-grey-suit">
                {{$city->hospitals->count()}} hospitales
            </p>


            <a href="{{route('web.cityPage',[rawurlencode($city->city)])}}"
               class="btn btn-ce-soir white-text text-center button-border size-button">
               Ver hospitales
            </a>

        </div>

        <!-- END CITY CONTENT -->
    </div>
</div>




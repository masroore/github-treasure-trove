<div class="row mt-5">
    <div class="col-12">

        <!--GENERAL FILTER -->
        <select id="orderSelect" class="form-control btn-full-rounded">
            <option value="">Ver todos</option>
            <option value="{{route('web.getMomSearchOrderBy',['precio','asc'])}}">
                Ordenar de menor a mayor precio
            </option>
            <option value="{{route('web.getMomSearchOrderBy',['precio','desc'])}}">
                Ordenar de mayor a menor precio
            </option>
            <option value="{{route('web.getMomSearchOrderBy',['populares','asc'])}}">
                Ordenar de menor a mayor rating
            </option>
            <option value="{{route('web.getMomSearchOrderBy',['populares','desc'])}}">
                Ordenar de mayor a menor rating
            </option>

        </select>
        <!-- END GENERAL FILTER -->


        <!-- RATING FILTER -->
        <div class="row">
            <div class="col-12">

                <h4 class="text-center text-ce-soir my-3">Rating</h4>

                <ul class="list-filter px-0">
                    @foreach($ratings as $rating)
                        <li class="list-filter-item">
                            <a href="{{route('web.getMomSearchByPopularity',[rawurlencode($rating->rating_description)])}}"
                               class="text-grey-suit font-weight-bold">
                                @for($i=1;$i<=$rating->star_number;++$i)
                                    <i class="fas fa-star text-selective-yellow"></i>

                                @endfor
                                <span class="float-right clearfix font-weight-bold">({{$rating->hospitals->count()}})</span>
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
        <!-- END RATING -->


        <!-- CITIES FILTER -->
        <h4 class="text-center text-ce-soir my-3">Ciudades</h4>

        <ul class="list-filter px-0">
            <li class="list-filter-item">
                <a href="{{route('web.getMomSearch')}}" class="text-grey-suit font-weight-bold">Ver
                    todos</a>
            </li>
            @foreach ($cities as $city)
                <li class="list-filter-item">
                    <a href="{{route('web.getMomSearchByCity',[rawurlencode($city->city)])}}"
                       class="text-grey-suit font-weight-bold">
                        {{$city->city}} <span class="float-right clearfix font-weight-bold">({{$city->hospitals->count()}})</span>
                    </a>
                </li>
            @endforeach
        </ul>
        <!-- END CITIES FILTER -->
    </div>
</div>


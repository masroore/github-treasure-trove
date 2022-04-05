@include("_partials/error_handling",["variable"=>"error","color"=>"danger"])

<div class="py-5 pt-xl-0 pb-xl-5">
    <h1 class="text-center font-weight-bold text-ce-soir mb-1">Paquetes</h1>


    <div class="row justify-content-start mt-3">

        @foreach ($hospital->products as $product)


            <div class="col-12 col-md-8 col-lg-3 mt-3">
                <div class="card item-card bg-white shadow border-ice-cold">

                    <div class="card-body text-center px-0 pt-0">
                        <div class="item-title">
                            {{number_format($product->price,0)}} USD
                        </div>

                        <div class="px-3">
                            <h2 class="card-title text-center mt-3 text-grey-suit font-weight-bold">
                                {{$product->product->product}}
                            </h2>


                            <ul class="list-group list-group-flush ">
                                @foreach ($product->product->details as $detail)
                                    <li class="list-group-item">{{$detail->detail}}</li>
                                @endforeach
                            </ul>

                            @if(Auth::guest())
                                <a href="{{route('web.getRegisterMom')}}"

                                   class="btn btn-block btn-ce-soir btn-full-rounded font-campton btn-lg p-3 text-light mt-3">
                                    Comenzar mi proceso
                                </a>
                            @else

                                <a href="{{route('web.momCreateCart',[$product->id])}}"
                                   class="btn btn-block btn-ce-soir btn-full-rounded font-campton btn-lg p-3 text-light mt-3">
                                    Seleccionar paquete
                                </a>


                            @endif


                        </div>

                    </div>
                </div>
            </div>
        @endforeach


    </div>
</div>

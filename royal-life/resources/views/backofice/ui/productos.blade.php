

<div class="container">

    <div class="row   mt-3">
        @foreach ($packages as $producto )
      <div class="col-sm-4">

        <div class="card zoom2 mt-1" style="width: 23rem;  background:#FFFFFF;">
            <div class="card-body">

                <div class="text-center bg " style="">
                    <a  href="{{action('TiendaController@detalleproducto', ['producto' => $producto->id ])}}" method="GET">
                @csrf
                @if($producto->img == null)
                      <img class="mx-auto d-block  img-fluid "
                       src="{{asset('assets/img/home/producto21.png')}}"
                       alt="Product Image"
                      >
               @else
                     <img class="mx-auto d-block  img-fluid w-100"
                          src="{{ asset('storage/photo-producto/'.$producto->img) }}"
                          alt="Product Image"
                          style="height: 15.3rem;  ">
               @endif
                    </a>
            </div>
            <button href="" class="btn-cre custominput">
                <p class="" >{{ ucfirst($producto->getCategories->categories_name)}}</p>
            </button>
            <a class=" blok text-right" style="color: #303030; font-size: 20px; float: right;">
            <strong>${{$producto->price}}</strong></a>

              <h5 class="card-title "><strong> {{$producto->name}} </strong> </h5>
              <p class="card-text text-dark mb-1">{{ Str::words( strip_tags($producto->description) , 18 )}}</p>

            </div>
          </div>

      </div>
      @endforeach
    </div>
  </div>

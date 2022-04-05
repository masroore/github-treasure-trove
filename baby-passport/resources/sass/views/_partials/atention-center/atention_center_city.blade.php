
<div class="col-12 col-lg-4 mb-4">
    <!-- Card -->
    <div class="card">

      <!--Card image-->
      <div class="view overlay">
        <img class="img img-fluid shadow"
                 src="{{asset('storage/cities/'.$city->image)}}"
                 alt="Card image cap">
        <a href="#!">
          <div class="mask rgba-white-slight"></div>
        </a>
      </div>

      <!--Card content-->
      <div class="card-body">

        <!--Title-->
        <h4 class="h4-responsive card-title text-dark mb-1">{{$city->city}}</h4>
        <!--Text-->
        <p class="card-text">{{$city->copy}}</p>
        <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
        <a href="{{route('web.cityPage',[rawurlencode($city->city)])}}"
            class="btn btn-spray white-text button-border">
            </i> Ver más información
         </a>

      </div>

    </div>
    <!-- Card -->
  </div>

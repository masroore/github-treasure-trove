@extends('layouts.app')

@section('title')
    <title>BabyPassport|  </title>
@endsection

@section('content')

    <!-- CITY BG IMAGE -->
    <section class=" view bg-atention-center-USA px-5"
    style="background-image: url(https://user-images.githubusercontent.com/27248841/75178823-71d9c300-56fe-11ea-8129-31871a92c98e.jpg)">

        <div class="mask rgba-pink-light"></div>

        <div class="row justify-content-center justify-content-lg-start">

            <div class="col-12 col-md-7 col-lg-7 pt-5">
                <h2 class="h1-responsive text-ce-soir">Tu bebé en Estados Unidos</h2>
                <h1 class="h2-responsive text-ce-soir">
                   Consulta nuestros paquetes de maternidad en Estados unidos
                </h1>
            </div>


        </div>


    </section>

 <!-- CITIES -->
 <section class="cities container pt-5">

    <div class="row my-0 my-lg-3 justify-content-center justify-content-md-start justify-content-xl-start">
        @foreach($cities as $city)
            @include('_partials/atention-center/atention_center_city',['city'=>$city])
        @endforeach
    </div>


</section>
<!-- END CITIES -->
  

    <!-- BLOG TITULE -->
    <section class="cities container-fluid pt-5">

        <h2 class="text-center text-ce-soir mb-1">BLOG PARA TI</h2>
        <div class="section-divider bg-mandys-pink my-3"></div>

    </section>
    <!-- BLOG TITULE -->


    <!-- BLOG POSTS -->
    <section class="container-fluid blogs my-0 my-lg-3">
        <div class="row justify-content-center justify-content-md-start justify-content-xl-start">
            @foreach ($blogs as $blog)
                @include('_partials/welcome/blog_item')
            @endforeach
        </div>
    </section>
    <!-- END BLOG POSTS -->
   
@endsection



@section('custom_scripts')
    <script src="{{asset(mix('/js/web/atention-center.js'))}}"></script>
@endsection

<script>

function selectCity(){

e.preventDefault();

var valueCity = document.getElementById("select").value;
if (valueCity===CDMX){

}else{


}
 

}

</script>

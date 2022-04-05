@extends('layouts.app')

@section('title')
    <title>BabyPassport|  </title>
@endsection

@section('content')

    <!-- CITY BG IMAGE -->
    <section class="view bg-atention-center pt-5 mt-5  px-5"
         style="background-image:url(https://user-images.githubusercontent.com/27248841/75050225-34243280-5491-11ea-9ee4-18c76eb4389c.jpg);">

        <div class="mask rgba-pink-light"></div>

        <div class="row justify-content-center justify-content-lg-start">

            <div class="col-12 col-md-8 col-lg-8 pt-5">
                <h1 class="h1-responsive text-ce-soir pt-5">
                    Centros de atención Baby Passport
                </h1>
            </div>


        </div>


    </section>

    <div class="mx-3 mx-lg-5 px-lg-5 my-4 my-lg-3 py-lg-5">
        <h1 class="text-grey-suit lead text-justify">Nuestros lugares para dar la luz en Estados Unidos</h1>
    </div>

    <h2 class="text-ce-soir text-center mt-5">Elige tu ciudad</h2>
    <div class="section-divider bg-mandys-pink  my-3"></div>
    
    <div class="row mb-5 mb-4">
        <div class="mx-auto pb-5 mb-5">
            
        <select class="browser-default custom-select" id="select" name="select";>
            <option selected>Selecciona una ciudad</option>
            <option value="{{route('web.centerAtention',['CDMX'])}}">Mi parto en México</option> 
            <option value="{{route('web.centerAtention',['USA'])}}">Mi parto en Estados Unidos</option>
        </select>
        </div>
    </div>
   
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

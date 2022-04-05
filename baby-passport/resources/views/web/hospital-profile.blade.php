@extends('layouts.app')



@section('title')
    {!! SEO::generate() !!}
@endsection

@section('content')

   
<!-- Grid row -->
<div class="row" >

  <!-- Grid column -->
  <div class="col-md-6 pt-5 mt-3 pt-lg-0 mt-lg-0 pr-0">

    <img src="{{asset('storage/hospital/'.$hospital->photo_two)}}" class="img-fluid z-depth-1"
      alt="Responsive image">

  </div>
  <!-- Grid column -->

  <!-- Grid column -->
  <div class="col-md-6 pl-0">

    <img src="{{asset('storage/hospital/'.$hospital->photo_three)}}" class="img-fluid z-depth-1"
    alt="Responsive image">

  </div>
  <!-- Grid column -->

</div>
<!-- Grid row -->
        

  


    <section class="container-fluid px-5 hospital-profile my-5">


        <div class="row">
            <div class="col-12 col-lg-8">
                <h1 class="display-4 text-left text-ce-soir">{{$hospital->name}}</h1>
                <p class="text-left">
                    @for($i=1;$i<=$hospital->rating->star_number;++$i)
                        <i class="fas fa-star fa-2x text-spray"></i>
                    @endfor
                </p>
                
                <h2 class="mt-5 font-weight-bold text-mandys-pink">Experiencia</h2>

                <p class="mt-3 text-grey-suit text-justify lead">
                    {{$hospital->about}}
                </p>

             
                <p class="mt-3 text-grey-suit text-justify lead">
                    ¿Ya imaginaste este momento? 
                
                </p>

                <p class="mt-3 text-grey-suit text-justify lead">
                    ¡Conoce cómo dar a luz en Estados Unidos con Baby Passport!
                </p>

                <hr class="my-5">

                <h2 class="h2-responsive mt-5 mb-3 font-weight-bold text-mandys-pink">Servicios</h2>


                <div class="row services-list justify-content-center">


                    @foreach($hospital->products as $index=>$hProduct)
                        <div class="col-lg-6 col-md-12 mb-lg-0 mb-4">

                            <!-- Pricing card -->
                            <div class="card pricing-card">

                                <!-- Price -->
                                <div class="price header white-text {{$index%2 ==0?'blue':'pink'}} rounded-top">
                                    <h2 class="number">{{number_format($hProduct->price,2,',','')}} USD</h2>
                                    <div class="version">
                                        <h5 class="mb-0"> {{$hProduct->product->product}}</h5>
                                       
                                    </div>
                                </div>
                              
                                <!-- Features -->
                                <div class="card-body striped mb-1 darker-striped">

                                    <ul>
                                        @foreach($hProduct->product->details as $pDetail)
                                            <li>
                                                <p><i class="fas fa-check green-text pr-2 "></i>{{$pDetail->detail}}</p>
                                            </li>
                                        @endforeach()
                                    </ul>

                                    <button type="submit" id="{{$hProduct->product->id}}" name="{{$hProduct->product->id}}" value="{{$hProduct->product->product}}"  class="btn btn-whatspackge btn-ce-soir btn-lg white-text waves-effect waves-light" >
                                        <i class="fas fa-calendar mr-2"></i> Agendar     
                                    </button>

                                </div>
                                <!-- Features -->

                            </div>
                            <!-- Pricing card -->

                        </div>
                    @endforeach()


                </div>

            </div>

            <div class="col-12 col-lg-4">

                <!-- Card -->
                <div class="card sticky-top mt-5">

                    <!-- Card body -->
                    <div class="card-body text-center">

                        <h2 class="h2-responsive text-ce-soir">Agenda tu cita</h2>
                        <!-- Material form register -->
                        <form class="needs-validation" novalidate>

                            <div class="mb-3 md-form">

                                <label for="validationCustom012">Nombre completo</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="" value=""
                                       required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3 md-form">

                                <label for="validationCustom022">Teléfono</label>
                                <input type="text" class="form-control" id="phone" name="phone" value=""
                                       required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>

                            <button type="submit" id="hospital" name="{{$hospital->name}}" value="{{$hospital->name}}"  class="btn btn-whatsData btn-ce-soir btn-lg white-text" >
                               <i class="fas fa-calendar mr-2"></i> Agendar
                            </button>

                        </form>

                        <!-- Material form register -->

                    </div>
                    <!-- Card body -->

                </div>
            </div>
        </div>


    </section>






@endsection





@section('custom_styles')

@endsection

@section("custom_scripts")

    <script src="{{asset(mix('js/web/hospital.profile.js'))}}"></script>
    <script>
    

    </script>
@endsection

@extends('layouts.app')

@section('content')
<section class="our-checkout-area bg__white">
            <div class="container">
                <div class="row">
                    
                        <div class="ckeckout-left-sidebar">
                            <!-- Start Checkbox Area -->
                            <div class="checkout-form">

                              <div class="panel-body">  
                                    @if ($sucess)
                                        <div class="alert alert-success text-center">
                                           
                                            <p>{{ $sucess }}</p>


                                        </div>

                                        <a href="{{route('home')}}" target="_self"><button type="button" class="btn btn-warning  btn-lg btn-block">Continue Shopping</button></a>
                                    @endif
                  
                                </div>

                            </div>
                          
                        </div>
                    
                </div>
            </div>
        </section>
@endsection
@section('ext_js')
    
@endsection


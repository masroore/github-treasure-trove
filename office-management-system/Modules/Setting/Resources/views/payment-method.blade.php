@extends('backEnd.master')
@section('mainContent')

<section class="mb-40 student-details">
    <div class="container-fluid p-0">
        <div class="row">
            <!-- Select a Payment Gateway --> 
            
            <div class="col-lg-3">

                <div class="main-title pt-10">
                    <h3 class="mb-30">@lang('setting.Select a payment gateway')   </h3>  
                </div>

                <form method="POST" action="{{ route('update-active-method') }}">
                    @csrf
                    
                    <div class="white-box">
                        <div class="row mt-40">
                            <div class="col-lg-12">
                                
                               @foreach($paymeny_gateways as $value)

                               
                               <div class="input-effect">
                                <input type="checkbox" id="gateway_{{@$value->gateway_name}}" class="common-checkbox class-checkbox" name="gateways[]" value="{{@$value->id}}" {{@$value->active_status == 1? 'checked':''}}>
                                <label for="gateway_{{@$value->gateway_name}}">{{@$value->gateway_name}}  
                                </label>
                            </div>

                            @endforeach


                            @if($errors->has('gateways'))
                            <span class="text-danger validate-textarea-checkbox" role="alert">
                                <strong>{{ $errors->first('gateways') }}</strong>
                            </span>
                            @endif

                        </div>
                    </div>

                    @php 
                    
                    @endphp
                    <div class="row mt-40">
                        <div class="col-lg-12 text-center">
                            @if(Illuminate\Support\Facades\Config::get('app.app_sync'))
                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Disabled For Demo ">
                                <button  style="pointer-events: none;" class="primary-btn fix-gr-bg tooltip-wrapper  demo_view" type="button" ><span class="ti-check"></span>
                                @lang('setting.update')</button>
                            </span>
                            @else
                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip" title="{{@$tooltip}}">
                                <span class="ti-check"></span>
                                @lang('setting.update')
                            </button>
                            @endif
                        </div>
                    </div>
                </div>


            </form>

        </div>
        <!-- End Select a Payment Gateway -->  


        <div class="col-lg-9">
           <div class="row">
            <div class="main-title pt-10"> 
            </div>
            <ul class="nav nav-tabs justify-content-end mt-sm-md-20 mb-30" role="tablist">
                @foreach($paymeny_gateways as $row) 
                
                
                <li class="nav-item">
                    <a class="nav-link {{ $row->gateway_name=='Stripe' ? 'active' : '' }}" href="#{{@$row->gateway_name}}" role="tab" data-toggle="tab" aria-controls="{{ $row->gateway_name }}" aria-selected="{{ $row->gateway_name=='Stripe' ? 'true' : 'false' }}" >{{@$row->gateway_name}}</a> 
                </li> 
                

                @endforeach 
            </ul>
        </div>

        <!-- Tab panes -->
        <div class="tab-content">

            @foreach($paymeny_gateways as $row) 

            <div role="tabpanel" class="tab-pane fade {{ $row->gateway_name=='Stripe' ? 'show active' : '' }}" aria-labelledby="{{@$row->gateway_name}}"  id="{{@$row->gateway_name}}">

                <form class="form-horizontal" action="{{ route('update-payment-method-settings', $row->id) }}" method="POST">

                    @csrf
                    @method('PUT')
                    

                    <div class="white-box">
                        <div class="row mb-30">
                         <div class="col-md-10">
                            
                            <div class="row">
                                <div class="col-lg-12 mb-30">
                                    <div class="input-effect">
                                        <input class="primary-input form-control" type="text" name="gateway_name" id="" autocomplete="off" value="{{ $row->gateway_name }}">
                                        <label>@lang('setting.Gateway name')</label>
                                        <span class="focus-border"></span>
                                        <span class="modal_input_validation red_alert"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-12 mb-30">
                                    <div class="input-effect">
                                        <input class="primary-input form-control read-only-input" type="text" name="gateway_username" id="gateway_gateway_username" autocomplete="off" value="{{ $row->gateway_username }}">
                                        <label>@lang('setting.Gateway username')</label>
                                        <span class="focus-border"></span>
                                        <span class="modal_input_validation red_alert"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-12 mb-30">
                                    <div class="input-effect">
                                        <input class="primary-input form-control read-only-input" type="text" name="gateway_api_key" id="gateway_gateway_secret_key" autocomplete="off" value="{{ $row->gateway_api_key }}">
                                        <label>@lang('setting.Gateway api key')</label>
                                        <span class="focus-border"></span>
                                        <span class="modal_input_validation red_alert"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-12 mb-30">
                                    <div class="input-effect">
                                        <input class="primary-input form-control" type="text" name="gateway_secret_key" id="gateway_gateway_publisher_key" autocomplete="off" value="{{ $row->gateway_secret_key }}">
                                        <label>@lang('setting.Gateway secret key')
                                            <span class="focus-border"></span>
                                            <span class="modal_input_validation red_alert"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 mb-30">
                                        <div class="input-effect">
                                            <input class="primary-input form-control" type="text" name="redirect_url" id="redirect_url" autocomplete="off" value="{{ $row->redirect_url }}">
                                            <label>{{ __('setting.Redirect Url') }}
                                                <span class="focus-border"></span>
                                                <span class="modal_input_validation red_alert"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-40">
                                <div class="col-lg-12 text-center">
                                    @if(Illuminate\Support\Facades\Config::get('app.app_sync'))
                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Disabled For Demo ">
                                        <button  style="pointer-events: none;" class="primary-btn fix-gr-bg tooltip-wrapper  demo_view" type="button" ><span class="ti-check"></span>
                                        @lang('setting.update')</button>
                                    </span>
                                    @else
                                    <button class="primary-btn fix-gr-bg" data-toggle="tooltip" title="" data-original-title="">
                                        <span class="ti-check"></span>
                                        @lang('setting.update')                                            
                                    </button>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                @endforeach
            </div>
        </div> 
    </div>
</div>

</section>
@endsection

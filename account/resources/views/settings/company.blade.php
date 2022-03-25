@extends('layouts.admin')
@section('page-title')
    {{__('Settings')}}
@endsection
@php
    $logo=asset(Storage::url('uploads/logo/'));
    $company_logo=Utility::getValByName('company_logo');
    $company_favicon=Utility::getValByName('company_favicon');
@endphp
@push('script-page')
    <script>
        $(document).on("change", "select[name='invoice_template'], input[name='invoice_color']", function () {
            var template = $("select[name='invoice_template']").val();
            var color = $("input[name='invoice_color']:checked").val();
            $('#invoice_frame').attr('src', '{{url('/invoices/preview')}}/' + template + '/' + color);
        });

        $(document).on("change", "select[name='proposal_template'], input[name='proposal_color']", function () {
            var template = $("select[name='proposal_template']").val();
            var color = $("input[name='proposal_color']:checked").val();
            $('#proposal_frame').attr('src', '{{url('/proposal/preview')}}/' + template + '/' + color);
        });

        $(document).on("change", "select[name='bill_template'], input[name='bill_color']", function () {
            var template = $("select[name='bill_template']").val();
            var color = $("input[name='bill_color']:checked").val();
            $('#bill_frame').attr('src', '{{url('/bill/preview')}}/' + template + '/' + color);
        });
    </script>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="nav-tabs">
                <div class="col-lg-12 our-system">
                    <div class="row">
                        <ul class="nav nav-tabs my-4">
                            <li>
                                <a data-toggle="tab" href="#business-setting" class="active">{{__('Business Setting')}}</a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#system-setting" class="">{{__('System Setting')}} </a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#company-setting" class="">{{__('Company Setting')}} </a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#proposal-template-setting" class="">{{__('Proposal Print Setting')}} </a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#invoice-template-setting" class="">{{__('Invoice Print Setting')}} </a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#bill-template-setting" class="">{{__('Bill Print Setting')}} </a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#payment-setting" class="">{{__('Payment Setting')}} </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="business-setting" class="tab-pane in active">
                        {{Form::model($settings,array('route'=>'business.setting','method'=>'POST','enctype' => "multipart/form-data"))}}
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                <h4 class="h4 font-weight-400 float-left pb-2">{{__('Business settings')}}</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-md-6">
                                <h4 class="small-title">{{__('Logo')}}</h4>
                                <div class="card setting-card setting-logo-box">
                                    <div class="logo-content">
                                        <img src="{{$logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')}}" class="big-logo" alt=""/>
                                    </div>
                                    <div class="choose-file mt-4">
                                        <label for="company_logo">
                                            <div>{{__('Choose file here')}}</div>
                                            <input type="file" class="form-control" name="company_logo" id="company_logo" data-filename="edit-company_logo">
                                        </label>
                                        <p class="edit-company_logo"></p>
                                    </div>
                                    <p class="mt-3 text-primary"> {{__('These Logo will appear on Bill and Invoice as well.')}}</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-md-6">
                                <h4 class="small-title">{{__('Favicon')}}</h4>
                                <div class="card setting-card setting-logo-box">
                                    <div class="logo-content">
                                        <img src="{{$logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')}}" class="small-logo" alt=""/>
                                    </div>
                                    <div class="choose-file mt-5">
                                        <label for="company_favicon">
                                            <div>{{__('Choose file here')}}</div>
                                            <input type="file" class="form-control" name="company_favicon" id="company_favicon" data-filename="edit-company-favicon">
                                        </label>
                                        <p class="edit-company-favicon"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-md-6">
                                <h4 class="small-title">{{__('Settings')}}</h4>
                                <div class="card setting-card setting-logo-box">
                                    <div class="form-group">
                                        {{Form::label('title_text',__('Title Text'),array('class'=>'form-control-label'),array('class'=>'form-control-label')) }}
                                        {{Form::text('title_text',null,array('class'=>'form-control','placeholder'=>__('Title Text')))}}
                                        @error('title_text')
                                        <span class="invalid-title_text" role="alert">
                                             <strong class="text-danger">{{ $message }}</strong>
                                             </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-12 text-right">
                                <input type="submit" value="{{__('Save Changes')}}" class="btn-submit">
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                    <div id="system-setting" class="tab-pane">
                        <div class="col-md-12">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2">{{__('System Settings')}}</h4>
                                </div>
                            </div>
                            <div class="card bg-none">
                                {{Form::model($settings,array('route'=>'system.settings','method'=>'post'))}}
                                <div class="card-body pd-0">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            {{Form::label('site_currency',__('Currency *'),array('class'=>'form-control-label')) }}
                                            {{Form::text('site_currency',null,array('class'=>'form-control font-style'))}}
                                            <small> {{__('Note: Add currency code as per three-letter ISO code.')}}<br> <a href="https://stripe.com/docs/currencies" target="_blank">{{__('you can find out here..')}}</a></small> <br>
                                            @error('site_currency')
                                            <span class="invalid-site_currency" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('site_currency_symbol',__('Currency Symbol *'),array('class'=>'form-control-label')) }}
                                            {{Form::text('site_currency_symbol',null,array('class'=>'form-control'))}}
                                            @error('site_currency_symbol')
                                            <span class="invalid-site_currency_symbol" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="example3cols3Input">{{__('Currency Symbol Position')}}</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="custom-control custom-radio mb-3">

                                                            <input type="radio" id="customRadio5" name="site_currency_symbol_position" value="pre" class="custom-control-input" @if(@$settings['site_currency_symbol_position'] == 'pre') checked @endif>
                                                            <label class="custom-control-label" for="customRadio5">{{__('Pre')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="customRadio6" name="site_currency_symbol_position" value="post" class="custom-control-input" @if(@$settings['site_currency_symbol_position'] == 'post') checked @endif>
                                                            <label class="custom-control-label" for="customRadio6">{{__('Post')}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="site_date_format" class="form-control-label">{{__('Date Format')}}</label>
                                            <select type="text" name="site_date_format" class="form-control select2" id="site_date_format">
                                                <option value="M j, Y" @if(@$settings['site_date_format'] == 'M j, Y') selected="selected" @endif>Jan 1,2015</option>
                                                <option value="d-m-Y" @if(@$settings['site_date_format'] == 'd-m-Y') selected="selected" @endif>d-m-y</option>
                                                <option value="m-d-Y" @if(@$settings['site_date_format'] == 'm-d-Y') selected="selected" @endif>m-d-y</option>
                                                <option value="Y-m-d" @if(@$settings['site_date_format'] == 'Y-m-d') selected="selected" @endif>y-m-d</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="site_time_format" class="form-control-label">{{__('Time Format')}}</label>
                                            <select type="text" name="site_time_format" class="form-control select2" id="site_time_format">
                                                <option value="g:i A" @if(@$settings['site_time_format'] == 'g:i A') selected="selected" @endif>10:30 PM</option>
                                                <option value="g:i a" @if(@$settings['site_time_format'] == 'g:i a') selected="selected" @endif>10:30 pm</option>
                                                <option value="H:i" @if(@$settings['site_time_format'] == 'H:i') selected="selected" @endif>22:30</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('invoice_prefix',__('Invoice Prefix'),array('class'=>'form-control-label')) }}
                                            {{Form::text('invoice_prefix',null,array('class'=>'form-control'))}}
                                            @error('invoice_prefix')
                                            <span class="invalid-invoice_prefix" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('proposal_prefix',__('Proposal Prefix'),array('class'=>'form-control-label')) }}
                                            {{Form::text('proposal_prefix',null,array('class'=>'form-control'))}}
                                            @error('proposal_prefix')
                                            <span class="invalid-proposal_prefix" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('bill_prefix',__('Bill Prefix'),array('class'=>'form-control-label')) }}
                                            {{Form::text('bill_prefix',null,array('class'=>'form-control'))}}
                                            @error('bill_prefix')
                                            <span class="invalid-bill_prefix" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('customer_prefix',__('Customer Prefix'),array('class'=>'form-control-label')) }}
                                            {{Form::text('customer_prefix',null,array('class'=>'form-control'))}}
                                            @error('customer_prefix')
                                            <span class="invalid-customer_prefix" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('vender_prefix',__('Vender Prefix'),array('class'=>'form-control-label')) }}
                                            {{Form::text('vender_prefix',null,array('class'=>'form-control'))}}
                                            @error('vender_prefix')
                                            <span class="invalid-vender_prefix" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('footer_title',__('Invoice/Bill Footer Title'),array('class'=>'form-control-label')) }}
                                            {{Form::text('footer_title',null,array('class'=>'form-control'))}}
                                            @error('footer_title')
                                            <span class="invalid-footer_title" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            {{Form::label('decimal_number',__('Decimal Number Format'),array('class'=>'form-control-label')) }}
                                            {{Form::number('decimal_number', null, ['class'=>'form-control'])}}
                                            @error('decimal_number')
                                            <span class="invalid-decimal_number" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('journal_prefix',__('Journal Prefix'),array('class'=>'form-control-label')) }}
                                            {{Form::text('journal_prefix',null,array('class'=>'form-control'))}}
                                            @error('journal_prefix')
                                            <span class="invalid-journal_prefix" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            {{Form::label('shipping_display',__('Shipping Display in Proposal / Invoice / Bill ?'),array('class'=>'form-control-label')) }}
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="email-template-checkbox custom-control-input" name="shipping_display" id="email_tempalte_13" {{($settings['shipping_display']=='on')?'checked':''}} >
                                                <label class="custom-control-label form-control-label" for="email_tempalte_13"></label>
                                            </div>

                                            @error('shipping_display')
                                            <span class="invalid-shipping_display" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('footer_notes',__('Invoice/Bill Footer Notes'),array('class'=>'form-control-label')) }}
                                            {{Form::textarea('footer_notes', null, ['class'=>'form-control','rows'=>'3'])}}
                                            @error('footer_notes')
                                            <span class="invalid-footer_notes" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12  text-right">
                                    <input type="submit" value="{{__('Save Changes')}}" class="btn-submit text-white">
                                </div>
                                {{Form::close()}}
                            </div>
                        </div>
                    </div>
                    <div id="company-setting" class="tab-pane">
                        <div class="col-md-12">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2">{{__('Company Settings')}}</h4>
                                </div>
                            </div>
                            <div class="card bg-none">
                                {{Form::model($settings,array('route'=>'company.settings','method'=>'post'))}}
                                <div class="card-body pd-0">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            {{Form::label('company_name *',__('Company Name *'),array('class'=>'form-control-label')) }}
                                            {{Form::text('company_name',null,array('class'=>'form-control font-style'))}}
                                            @error('company_name')
                                            <span class="invalid-company_name" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('company_address',__('Address'),array('class'=>'form-control-label')) }}
                                            {{Form::text('company_address',null,array('class'=>'form-control font-style'))}}
                                            @error('company_address')
                                            <span class="invalid-company_address" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('company_city',__('City'),array('class'=>'form-control-label')) }}
                                            {{Form::text('company_city',null,array('class'=>'form-control font-style'))}}
                                            @error('company_city')
                                            <span class="invalid-company_city" role="alert">
                                                                    <strong class="text-danger">{{ $message }}</strong>
                                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('company_state',__('State'),array('class'=>'form-control-label')) }}
                                            {{Form::text('company_state',null,array('class'=>'form-control font-style'))}}
                                            @error('company_state')
                                            <span class="invalid-company_state" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('company_zipcode',__('Zip/Post Code'),array('class'=>'form-control-label')) }}
                                            {{Form::text('company_zipcode',null,array('class'=>'form-control'))}}
                                            @error('company_zipcode')
                                            <span class="invalid-company_zipcode" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group  col-md-6">
                                            {{Form::label('company_country',__('Country'),array('class'=>'form-control-label')) }}
                                            {{Form::text('company_country',null,array('class'=>'form-control font-style'))}}
                                            @error('company_country')
                                            <span class="invalid-company_country" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('company_telephone',__('Telephone'),array('class'=>'form-control-label')) }}
                                            {{Form::text('company_telephone',null,array('class'=>'form-control'))}}
                                            @error('company_telephone')
                                            <span class="invalid-company_telephone" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('company_email',__('System Email *'),array('class'=>'form-control-label')) }}
                                            {{Form::text('company_email',null,array('class'=>'form-control'))}}
                                            @error('company_email')
                                            <span class="invalid-company_email" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('company_email_from_name',__('Email (From Name) *'),array('class'=>'form-control-label')) }}
                                            {{Form::text('company_email_from_name',null,array('class'=>'form-control font-style'))}}
                                            @error('company_email_from_name')
                                            <span class="invalid-company_email_from_name" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('registration_number',__('Company Registration Number *'),array('class'=>'form-control-label')) }}
                                            {{Form::text('registration_number',null,array('class'=>'form-control'))}}

                                        </div>

                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="customRadio8" name="tax_type" value="VAT" class="custom-control-input" {{($settings['tax_type'] == 'VAT')?'checked':''}} >
                                                            <label class="custom-control-label" for="customRadio8">{{__('VAT Number')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="customRadio7" name="tax_type" value="GST" class="custom-control-input" {{($settings['tax_type'] == 'GST')?'checked':''}}>
                                                            <label class="custom-control-label" for="customRadio7">{{__('GST Number')}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{Form::text('vat_number',null,array('class'=>'form-control','placeholder'=>__('Enter VAT / GST Number')))}}

                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-12  text-right">
                                    <input type="submit" value="{{__('Save Changes')}}" class="btn-submit text-white">
                                </div>
                                {{Form::close()}}
                            </div>
                        </div>
                    </div>
                    <div id="proposal-template-setting" class="tab-pane">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                <h4 class="h4 font-weight-400 float-left pb-2">{{__('Proposal Print Settings')}}</h4>
                            </div>
                        </div>
                        <div class="card">
                            <form id="setting-form" method="post" action="{{route('proposal.template.setting')}}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <form id="setting-form" method="post" action="{{route('proposal.template.setting')}}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="address" class="form-control-label">{{__('Proposal Template')}}</label>
                                                    <select class="form-control select2" name="proposal_template">
                                                        @foreach(Utility::templateData()['templates'] as $key => $template)
                                                            <option value="{{$key}}" {{(isset($settings['proposal_template']) && $settings['proposal_template'] == $key) ? 'selected' : ''}}>{{$template}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label form-control-label">{{__('Color Input')}}</label>
                                                    <div class="row gutters-xs">
                                                        @foreach(Utility::templateData()['colors'] as $key => $color)
                                                            <div class="col-auto">
                                                                <label class="colorinput">
                                                                    <input name="proposal_color" type="radio" value="{{$color}}" class="colorinput-input" {{(isset($settings['proposal_color']) && $settings['proposal_color'] == $color) ? 'checked' : ''}}>
                                                                    <span class="colorinput-color" style="background: #{{$color}}"></span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <button class="btn btn-sm btn-primary rounded-pill">
                                                    {{__('Save')}}
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-10">
                                            @if(isset($settings['proposal_template']) && isset($settings['proposal_color']))
                                                <iframe id="proposal_frame" class="w-100 h-1300" frameborder="0" src="{{route('proposal.preview',[$settings['proposal_template'],$settings['proposal_color']])}}"></iframe>
                                            @else
                                                <iframe id="proposal_frame" class="w-100 h-1300" frameborder="0" src="{{route('proposal.preview',['template1','fffff'])}}"></iframe>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div id="invoice-template-setting" class="tab-pane">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                <h4 class="h4 font-weight-400 float-left pb-2">{{__('Invoice Print Settings')}}</h4>
                            </div>
                        </div>
                        <div class="card">
                            <form id="setting-form" method="post" action="{{route('proposal.template.setting')}}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <form id="setting-form" method="post" action="{{route('template.setting')}}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="address" class="form-control-label">{{__('Invoice Template')}}</label>
                                                    <select class="form-control select2" name="invoice_template">
                                                        @foreach(Utility::templateData()['templates'] as $key => $template)
                                                            <option value="{{$key}}" {{(isset($settings['invoice_template']) && $settings['invoice_template'] == $key) ? 'selected' : ''}}>{{$template}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label form-control-label">{{__('Color Input')}}</label>
                                                    <div class="row gutters-xs">
                                                        @foreach(Utility::templateData()['colors'] as $key => $color)
                                                            <div class="col-auto">
                                                                <label class="colorinput">
                                                                    <input name="invoice_color" type="radio" value="{{$color}}" class="colorinput-input" {{(isset($settings['invoice_color']) && $settings['invoice_color'] == $color) ? 'checked' : ''}}>
                                                                    <span class="colorinput-color" style="background: #{{$color}}"></span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <button class="btn btn-sm btn-primary rounded-pill">
                                                    {{__('Save')}}
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-10">
                                            @if(isset($settings['invoice_template']) && isset($settings['invoice_color']))
                                                <iframe id="invoice_frame" class="w-100 h-1450" frameborder="0" src="{{route('invoice.preview',[$settings['invoice_template'],$settings['invoice_color']])}}"></iframe>
                                            @else
                                                <iframe id="invoice_frame" class="w-100 h-1450" frameborder="0" src="{{route('invoice.preview',['template1','fffff'])}}"></iframe>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div id="bill-template-setting" class="tab-pane">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                <h4 class="h4 font-weight-400 float-left pb-2">{{__('Bill Print Settings')}}</h4>
                            </div>
                        </div>
                        <div class="card">
                            <form id="setting-form" method="post" action="{{route('proposal.template.setting')}}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <form id="setting-form" method="post" action="{{route('bill.template.setting')}}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="address" class="form-control-label">{{__('Bill Template')}}</label>
                                                    <select class="form-control select2" name="bill_template">
                                                        @foreach(Utility::templateData()['templates'] as $key => $template)
                                                            <option value="{{$key}}" {{(isset($settings['bill_template']) && $settings['bill_template'] == $key) ? 'selected' : ''}}>{{$template}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group form-control-label">
                                                    <label class="form-label">{{__('Color Input')}}</label>
                                                    <div class="row gutters-xs">
                                                        @foreach(Utility::templateData()['colors'] as $key => $color)
                                                            <div class="col-auto">
                                                                <label class="colorinput">
                                                                    <input name="bill_color" type="radio" value="{{$color}}" class="colorinput-input" {{(isset($settings['bill_color']) && $settings['bill_color'] == $color) ? 'checked' : ''}}>
                                                                    <span class="colorinput-color" style="background: #{{$color}}"></span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <button class="btn btn-sm btn-primary rounded-pill">
                                                    {{__('Save')}}
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-10">
                                            @if(isset($settings['bill_template']) && isset($settings['bill_color']))
                                                <iframe id="bill_frame" class="w-100 h-1450" frameborder="0" src="{{route('bill.preview',[$settings['bill_template'],$settings['bill_color']])}}"></iframe>
                                            @else
                                                <iframe id="bill_frame" class="w-100 h-1450" frameborder="0" src="{{route('bill.preview',['template1','fffff'])}}"></iframe>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div id="payment-setting" class="tab-pane">
                        <div class="col-md-12">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2">{{__('Payment settings')}}</h4>
                                </div>
                            </div>
                            <div class="card bg-none company-setting">
                                {{Form::model($settings,['route'=>'company.payment.settings', 'method'=>'POST'])}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <small >{{__("This detail will use for collect payment on invoice from clients. On invoice client will find out pay now button based on your below configuration.")}}</small>
                                    </div>
                                    <div class="col-6 py-2">
                                        <h5 class="h5">{{__('Stripe')}}</h5>
                                    </div>
                                    <div class="col-6 py-2 text-right">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="enable_stripe" id="enable_stripe" {{ isset($settings['enable_stripe']) && $settings['enable_stripe'] == 'on' ? 'checked="checked"' : '' }}>
                                            <label class="custom-control-label form-control-label" for="enable_stripe">{{__('Enable Stripe')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('stripe_key',__('Stripe Key'),array('class'=>'form-control-label')) }}
                                            {{Form::text('stripe_key',(isset($settings['stripe_key'])?$settings['stripe_key']:''),['class'=>'form-control','placeholder'=>__('Enter Stripe Key')])}}
                                            @error('stripe_key')
                                            <span class="invalid-stripe_key" role="alert">
                                             <strong class="text-danger">{{ $message }}</strong>
                                         </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('stripe_secret',__('Stripe Secret'),array('class'=>'form-control-label')) }}
                                            {{Form::text('stripe_secret',(isset($settings['stripe_secret'])?$settings['stripe_secret']:''),['class'=>'form-control ','placeholder'=>__('Enter Stripe Secret')])}}
                                            @error('stripe_secret')
                                            <span class="invalid-stripe_secret" role="alert">
                                             <strong class="text-danger">{{ $message }}</strong>
                                         </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                    <div class="col-6 py-2">
                                        <h5 class="h5">{{__('PayPal')}}</h5>
                                    </div>
                                    <div class="col-6 py-2 text-right">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="enable_paypal" id="enable_paypal"  {{  isset($settings['enable_paypal']) && $settings['enable_paypal'] == 'on' ? 'checked="checked"' : '' }}>
                                            <label class="custom-control-label form-control-label" for="enable_paypal">{{__('Enable Paypal')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 pb-4">
                                        <label class="paypal-label form-control-label" for="paypal_mode">{{__('Paypal Mode')}}</label> <br>
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-primary btn-sm active">
                                                <input type="radio" name="paypal_mode" value="sandbox" {{ isset($settings['paypal_mode']) &&  $settings['paypal_mode'] == '' || isset($settings['paypal_mode']) && $settings['paypal_mode'] == 'sandbox' ? 'checked="checked"' : '' }}>{{__('Sandbox')}}
                                            </label>
                                            <label class="btn btn-primary btn-sm ">
                                                <input type="radio" name="paypal_mode" value="live" {{ isset($settings['paypal_mode']) &&  $settings['paypal_mode'] == 'live' ? 'checked="checked"' : '' }}>{{__('Live')}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="paypal_client_id">{{ __('Client ID') }}</label>
                                            <input type="text" name="paypal_client_id" id="paypal_client_id" class="form-control" value="{{isset($settings['paypal_client_id'])?$settings['paypal_client_id']:''}}" placeholder="{{ __('Client ID') }}"/>
                                            @if ($errors->has('paypal_client_id'))
                                                <span class="invalid-feedback d-block">
                                            {{ $errors->first('paypal_client_id') }}
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="paypal_secret_key">{{ __('Secret Key') }}</label>
                                            <input type="text" name="paypal_secret_key" id="paypal_secret_key" class="form-control" value="{{isset($settings['paypal_secret_key'])?$settings['paypal_secret_key']:''}}" placeholder="{{ __('Secret Key') }}"/>
                                            @if ($errors->has('paypal_secret_key'))
                                                <span class="invalid-feedback d-block">
                                            {{ $errors->first('paypal_secret_key') }}
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12  text-right">
                                    <input type="submit" value="{{__('Save Changes')}}" class="btn-submit text-white">
                                </div>
                                {{Form::close()}}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

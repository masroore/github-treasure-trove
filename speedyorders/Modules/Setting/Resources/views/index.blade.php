@extends('layouts.main')

@section('content')
    <div class="row">
        @include('setting::sidebar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Company Information</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('settings.general') }}" method="post">
                        <div class="form-group{{ $errors->has('company_name') ? ' has-error' :'' }}">
                            <label for="">Company/Agency Name</label>
                            <input type="text" name="company_name" id="" class="form-control" value="{{ Option::get('company_name') }}">
                            @if($errors->has('company_name'))
                                <span class="help-block">{{ $errors->first('company_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('company_address') ? ' has-error' :'' }}">
                            <label for="">Address Line</label>
                            <input type="text" name="company_address" id="" class="form-control" value="{{ Option::get('company_address') }}">
                            @if($errors->has('company_address'))
                                <span class="help-block">{{ $errors->first('company_address') }}</span>
                            @endif
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6{{ $errors->has('company_email') ? ' has-error' :'' }}">
                                <label for="">Email</label>
                                <input type="text" name="company_email" id="" class="form-control" value="{{ Option::get('company_email') }}">
                                @if($errors->has('company_email'))
                                    <span class="help-block">{{ $errors->first('company_email') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6{{ $errors->has('company_phone') ? ' has-error' :'' }}">
                                <label for="">Phone</label>
                                <input type="text" name="company_phone" id="" class="form-control" value="{{ Option::get('company_phone') }}">
                                @if($errors->has('company_phone'))
                                    <span class="help-block">{{ $errors->first('company_phone') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6{{ $errors->has('company_city') ? ' has-error' :'' }}">
                                <label for="">City Name</label>
                                <input type="text" name="company_city" id="" class="form-control" value="{{ Option::get('company_city') }}">
                                @if($errors->has('company_city'))
                                    <span class="help-block">{{ $errors->first('company_city') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6{{ $errors->has('company_country') ? ' has-error' :'' }}">
                                <label for="">Country Code</label>
                                <input type="text" name="company_country" id="" class="form-control"
                                       placeholder="eg: NP" value="{{ Option::get('company_country') }}">
                                @if($errors->has('company_country'))
                                    <span class="help-block">{{ $errors->first('company_country') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6{{ $errors->has('company_postal') ? ' has-error' :'' }}">
                                <label for="">Postal Code</label>
                                <input type="text" name="company_postal" id="" class="form-control"
                                       placeholder="eg: 44600" value="{{ Option::get('company_postal') }}">
                                @if($errors->has('company_postal'))
                                    <span class="help-block">{{ $errors->first('company_postal') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6{{ $errors->has('company_state') ? ' has-error' :'' }}">
                                <label for="">State Code</label>
                                <input type="text" name="company_state" id="" class="form-control" value="{{ Option::get('company_state') }}">
                                @if($errors->has('company_state'))
                                    <span class="help-block">{{ $errors->first('company_state') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6{{ $errors->has('company_street') ? ' has-error' :'' }}">
                                <label for="">Street</label>
                                <input type="text" name="company_street" id="" class="form-control" value="{{ Option::get('company_street') }}">
                                @if($errors->has('company_street'))
                                    <span class="help-block">{{ $errors->first('company_street') }}</span>
                                @endif
                            </div>

                        </div>
                        <div class="col-md-12 text-right">
                            @csrf
                            <button type="submit" class="btn btn-primary">UPDATE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.main')

@section('content')
    <div class="row">
        @include('adminsetting::sidebar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Company Information</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('admin.settings') }}" method="post" enctype="multipart/form-data">
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
                                <label for="">Email(CSD)</label>
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

                             <div class="form-group col-md-6{{ $errors->has('site_logo') ? ' has-error' :'' }}">
                                <label for="">Site Logo</label>
                                <input type="file" name="site_logo" class="form-control" value="{{ Option::get('site_logo') }}">
                                @if($errors->has('site_logo'))
                                    <span class="help-block">{{ $errors->first('site_logo') }}</span>
                                @endif
                            </div>

                            @if(Option::get('site_logo')!='')
                                <div class="form-group col-md-6">
                                    <label class="col-md-2 control-label"></label>
                                    <div class="col-md-8">
                                        <img src="{{url('images/'.Option::get('site_logo'))}}" width="200px">
                                    </div>
                                </div>
                            @endif


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

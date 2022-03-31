@extends('layouts.main')

@section('content')
    <div class="row">
        @include('adminsetting::sidebar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Cash On Delivery Information</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('admin.settings.update.cod') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="">Status</label>
                            <div class="checkbox">
                                <input id="enable_status" class="i-checks" type="radio" name="cod_enable_status" value="1" @if(old('cod_enable_status',Option::get('cod_enable_status'))=='1') checked @endif>
                                <label for="enable_status" style="color:#000000;">Enable</label>
                                <input id="enable_status-2" class="i-checks" type="radio" name="cod_enable_status" value="0" @if(old('cod_enable_status',Option::get('cod_enable_status'))=='0') checked @endif>
                                <label for="status-2" style="color:#000000;">Disable</label>
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

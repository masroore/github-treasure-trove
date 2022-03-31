@extends('layouts.main')

@section('content')
    <div class="row">
        @include('adminsetting::sidebar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Stripe Information</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('admin.settings.update.stripe') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="">Status</label>
                            <div class="checkbox">
                                <input id="enable_status" class="i-checks" type="radio" name="stripe_enable_status" value="1" @if(old('stripe_enable_status',Option::get('stripe_enable_status'))=='1') checked @endif>
                                <label for="enable_status" style="color:#000000;">Enable</label>
                                <input id="enable_status-2" class="i-checks" type="radio" name="stripe_enable_status" value="0" @if(old('stripe_enable_status',Option::get('stripe_enable_status'))=='0') checked @endif>
                                <label for="status-2" style="color:#000000;">Disable</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Envirnoment</label>
                            <div class="checkbox">
                                <input id="stripe_status" class="i-checks" type="radio" name="stripe_payment_mode" value="LIVE" @if(old('stripe_payment_mode',Option::get('stripe_payment_mode'))=='LIVE') checked @endif>
                                <label for="stripe_status" style="color:#000000;">Live</label>
                                <input id="status-2" class="i-checks" type="radio" name="stripe_payment_mode" value="SANDBOX" @if(old('stripe_payment_mode',Option::get('stripe_payment_mode'))=='SANDBOX') checked @endif>
                                <label for="status-2" style="color:#000000;">Sandbox</label>
                            </div>
                        </div>

                        <h3>For Sandbox</h3>

                        <div class="form-group{{ $errors->has('stripe_key') ? ' has-error' :'' }}">
                            <label for="">Test Client Id</label>
                            <input type="text" name="stripe_key" id="" class="form-control" value="{{ old('stripe_key',Option::get('stripe_key')) }}">
                            @if($errors->has('stripe_key'))
                                <span class="help-block">{{ $errors->first('stripe_key') }}</span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('stripe_secret') ? ' has-error' :'' }}">
                            <label for="">Test Secret key</label>
                            <input type="text" name="stripe_secret" id="" class="form-control" value="{{ old('stripe_secret',Option::get('stripe_secret')) }}">
                            @if($errors->has('stripe_secret'))
                                <span class="help-block">{{ $errors->first('stripe_secret') }}</span>
                            @endif
                        </div>

                        <h3>For Live</h3>

                        <div class="form-group{{ $errors->has('live_stripe_key') ? ' has-error' :'' }}">
                            <label for="">Live Client Id</label>
                            <input type="text" name="live_stripe_key" id="" class="form-control" value="{{ old('live_stripe_key',Option::get('live_stripe_key')) }}">
                            @if($errors->has('live_stripe_key'))
                                <span class="help-block">{{ $errors->first('live_stripe_key') }}</span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('live_stripe_secret') ? ' has-error' :'' }}">
                            <label for="">Live Secret key</label>
                            <input type="text" name="live_stripe_secret" id="" class="form-control" value="{{ old('live_stripe_secret',Option::get('live_stripe_secret')) }}">
                            @if($errors->has('live_stripe_secret'))
                                <span class="help-block">{{ $errors->first('live_stripe_secret') }}</span>
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

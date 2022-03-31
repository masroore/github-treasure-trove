@extends('layouts.main')

@section('content')
    <div class="row">
        @include('adminsetting::sidebar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Social Media Information</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('admin.settings.update.socialmedia') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group{{ $errors->has('facebook_url') ? ' has-error' :'' }}">
                            <label for="">Facebook</label>
                            <input type="text" name="facebook_url" id="" class="form-control" value="{{ old('facebook_url',Option::get('facebook_url')) }}">
                            @if($errors->has('facebook_url'))
                                <span class="help-block">{{ $errors->first('facebook_url') }}</span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('instagram_url') ? ' has-error' :'' }}">
                            <label for="">Instagram</label>
                            <input type="text" name="instagram_url" id="" class="form-control" value="{{ old('instagram_url',Option::get('instagram_url')) }}">
                            @if($errors->has('instagram_url'))
                                <span class="help-block">{{ $errors->first('instagram_url') }}</span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('pinterest_url') ? ' has-error' :'' }}">
                            <label for="">Pinterest</label>
                            <input type="text" name="pinterest_url" id="" class="form-control" value="{{ old('pinterest_url',Option::get('pinterest_url')) }}">
                            @if($errors->has('pinterest_url'))
                                <span class="help-block">{{ $errors->first('pinterest_url') }}</span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('youtube_url') ? ' has-error' :'' }}">
                            <label for="">Youtube</label>
                            <input type="text" name="youtube_url" id="" class="form-control" value="{{ old('youtube_url',Option::get('youtube_url')) }}">
                            @if($errors->has('youtube_url'))
                                <span class="help-block">{{ $errors->first('youtube_url') }}</span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('twitter_url') ? ' has-error' :'' }}">
                            <label for="">Twitter</label>
                            <input type="text" name="twitter_url" id="" class="form-control" value="{{ old('twitter_url',Option::get('twitter_url')) }}">
                            @if($errors->has('twitter_url'))
                                <span class="help-block">{{ $errors->first('twitter_url') }}</span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('linkedin_url') ? ' has-error' :'' }}">
                            <label for="">Linked In</label>
                            <input type="text" name="linkedin_url" id="" class="form-control" value="{{ old('linkedin_url',Option::get('linkedin_url')) }}">
                            @if($errors->has('linkedin_url'))
                                <span class="help-block">{{ $errors->first('linkedin_url') }}</span>
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

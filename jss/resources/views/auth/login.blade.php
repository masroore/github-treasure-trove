@extends('app')

@section('content')
    <style>
        span{
            font-size: 23px;
            color: #1565C0;
            line-height: 40px;
            padding-left: 9px;
            vertical-align: bottom;
        }
    </style>
    <div class="position-relative login-div">
        <div class="login-container">
            <div class="login-bg-div"></div>
            <div class="panel-default">
                <div class="panel-heading login-label">登录</div>
                <div class="login-logo-div text-center">
                    <img src="{{ cAsset('assets/css/img/logo.png') }}" style="filter: grayscale(0);">
                </div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li><strong>{{ $error }}</strong></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="space-6"></div>
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="row">
                        <div class="col-md-12" style="width: 100%;">
                            <div class="form-group">
                                <input type="text" class="form-control" name="account" value="{{ old('account') }}" placeholder="用户名" style="font-size: 18px;padding: 8px!important;" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="密码" style="font-size: 18px;padding: 8px!important;" autocomplete="off">
                            </div>

                            <div class="space"></div>

                            <div class="form-group" style="text-align: center">
                                <button type="submit" class="width-100 btn btn-sm btn-primary"  style="font-size: 18px;padding: 8px!important;">
                                    <i class="icon-key"></i>登录
                                </button>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

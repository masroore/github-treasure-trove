<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>School Management System| Lockscreen</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{URL::to('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{URL::to('bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{URL::to('bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{URL::to('dist/css/AdminLTE.min.css')}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

   <link rel="shortcut icon" href="{{ URL::to('images/logo.png')}}" type="image/x-icon"/>
</head>
<body class="hold-transition lockscreen">
    <!-- Automatic element centering -->
<div class="lockscreen-wrapper">
            @error('email')
                 <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                 </div>
             @enderror
            @error('password')
            <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                 </div>
            @enderror

  <div class="lockscreen-logo">
    <a href="#"><b>Confirm Password</b></a>
  </div>
  <!-- User name -->
  <div class="lockscreen-name">{{ session('fullname') }}</div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
      <img src="{{ asset('storage')}}/{{ session('pro_pic') }}" alt="User Image">
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials" action="{{ route('lms-login-check') }}" method="post">
      @csrf
      <?php

        $index = App\User::where('email',session('email'))->first();
      ?>
      <input type="hidden" class="form-control  @error('index') is-invalid @enderror" name="index" placeholder="Index Number" value="{{$index->indexnumber}}">

      <input type="email" name="email" value="@if (session()->has('email')) {{ session('email') }} @endif" style="opacity: 0;position: absolute;">
      <input type="checkbox" name="remember" id="remember" checked style="opacity: 0;position: absolute;">
      <div class="input-group">
        <input type="password" name="password" class="form-control" placeholder="password">

        <div class="input-group-btn">
          <button type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Enter your password to retrieve your session
  </div>
  <div class="text-center">
    <a href="{{ route('student-login') }}">Or sign in as a different user</a>
  </div>
  <div class="lockscreen-footer text-center">
    Copyright &copy; 2014-<?php echo date('Y');?> <b><a href="#" class="text-black">OguSes IT Solutions</a></b><br>
    All rights reserved
  </div>
</div>
<!-- /.center -->

<!-- jQuery 3 -->
<script src="{{URL::to('bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{URL::to('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
</body>
</html>

@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
        <div class="container-fluid">
          <div class="fade-in">
            <div class="card">
              <div class="card-header"> <h2><center>Graph Login</center></h2></div>
              <div class="card-body">
              <a href="{{ route('login.facebook') }}" class="btn btn-block btn-primary">
                Iniciar sesión con Facebook
                </a>
              </div>  
            </div>
          </div>
        </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>
@endsection

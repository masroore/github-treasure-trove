@extends('layouts/MasterLogin')
@section('content')
                    @if (session()->has('message'))
                          <div class="alert alert-warning my-3">
                              {{ session('message') }}
                          </div>
                      @endif
                
                  <!--layout-->
                    <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="input-group mb-2">
                      <div class="input-group-prepend"><span class="input-group-text">
                      <i class="bi bi-envelope"></i>
                        </span></div>
                      <input type="email" class="form-control form-control-lg" name="email" placeholder="Email">
                    </div>
                      @error('email') <span class="d-block text-danger error mb-2">{{ $message }}</span>@enderror

                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                        <i class="bi bi-asterisk"></i>
                        </span></div>
                       <input type="password" class="form-control form-control-lg" name="password" placeholder="Password">
                    </div>
                       @error('password') <span class="d-block text-danger error  mb-2">{{ $message }}</span>@enderror
                      
                      <div class="recaptcha">
                      {!! htmlFormSnippet() !!}   
                      </div>

                      <div class="text-center my-3">  
                         <button  class="btn btn-outline-primary btn-lg" type="submit"><i class="cil-https"></i> Ingresar</button>
                      </div>  

                       </form>
            <!--layout-->
@endsection
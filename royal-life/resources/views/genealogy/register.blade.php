@extends('layouts.dashboard')

@section('title', 'Registro')

@section('content')
@php
    use App\Http\Controllers\Functions\SimplesController;
    $simples = new SimplesController;
    $nombre = '';
    if (!empty(request()->referred_id)) {
        $nombre = $simples->getName(request()->referred_id);
    }
@endphp
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Referido por: {{$nombre}}</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <form action="{{route('register')}}" method="POST" class="form">
                    @csrf
                    {{-- seccion de input ocultos --}}
                    <input type="hidden" name="form" value="interno">
                    <input type="hidden" name="idsponsor" value="{{request()->referred_id}}">
                    {{-- fin seccion de input ocultos --}}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-label-group">
                                    <input type="text" id="first-name-floating" class="form-control"
                                        placeholder="First Name" name="name">
                                    <label for="first-name-floating">Name</label>
                                    @error('name')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-label-group">
                                    <input type="email" id="email-id-floating" class="form-control" name="email"
                                        placeholder="Email">
                                    <label for="email-id-floating">Email</label>
                                </div>
                                @error('email')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="form-label-group">
                                    <input type="password" id="password-floating" class="form-control"
                                        name="password" placeholder="Password">
                                    <label for="password-floating">Password</label>
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="form-label-group">
                                    <input type="password" id="confirm-password-floating" class="form-control"
                                        name="password_confirmation" placeholder="Confirm Password">
                                    <label for="confirm-password-floating">Confirm Password</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <a href="{{route('home')}}" class="btn btn-outline-warning mr-1 mb-1">Cancel</a>
                                @if ($nombre != 'Usuario no Disponible o No Registrado')
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

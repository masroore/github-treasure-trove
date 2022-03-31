@extends('front.layouts.core')

@push('css')
@endpush


@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
            <li> <a href="{{ route('moj') }}">Moj račun</a></li>
            <li>Moj korisnički račun</li>
        </ul>
        <div class="row">
            <div id="content" >
                <h1 id="page-title">Moj korisnički račun</h1>
                <div class="col-md-12">
                    @if (Bouncer::is(auth()->user())->an('editor'))
                        <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i>
                            Vi ste ujedno i Prodavać na <b>{{ config('app.name') }}</b> platformi. Pogledajte svoju <a href="{{ route('dashboard') }}">administraciju...</a>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> Molimo vas da provjerite formu za unos podataka..! Možda nedostaju koji podaci?
                            <button type="button" class="close" data-dismiss="alert">×</button>
                        </div>
                    @endif

                        @if(session('success'))
                            <div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert">×</button>
                            </div>
                        @endif

                    <form action="{{ route('moj.update') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        <fieldset>
                            <legend>Osobni podaci</legend>
                            <div class="form-group clearfix  ">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label>Ime: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" name="fname" class="form-control grey" value="{{ isset($customer->details) ? $customer->details->fname : '' }}">
                                    @error('fname')
                                    <div class="text-danger">Ime je obvezno...</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label>Prezime: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" name="lname" class="form-control grey" value="{{ isset($customer->details) ? $customer->details->lname : '' }}">
                                    @error('lname')
                                    <div class="text-danger">Prezime je obvezno...</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group clearfix ">
                                <div class="col-md-12">
                                    <label>Adresa: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" name="address" class="form-control grey" value="{{ isset($customer->details) ? $customer->details->address : '' }}">
                                    @error('address')
                                    <div class="text-danger">Adresa je obvezna...</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Poštanski broj: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" name="zip" class="form-control grey" value="{{ isset($customer->details) ? $customer->details->zip : '' }}">
                                    @error('zip')
                                    <div class="text-danger">Poštanski broj je obvezan...</div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Grad: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" name="city" class="form-control grey" value="{{ isset($customer->details) ? $customer->details->city : '' }}">
                                    @error('city')
                                    <div class="text-danger">Grad je obvezan...</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group clearfix  ">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Broj telefona:</label>
                                    <input type="text" name="phone" class="form-control grey" value="{{ isset($customer->details) ? $customer->details->phone : '' }}">
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label>Email Adresa: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" name="email" class="form-control grey" value="{{ isset($customer) ? $customer->email : '' }}">
                                    @error('email')
                                    <div class="text-danger">Email adresa je obvezna...</div>
                                    @enderror
                                </div>
                            </div>

                            <legend style="margin-top: 36px;">Korisničko ime</legend>
                            <div class="form-group clearfix">
                                <div class="col-md-12">
                                    <label>Vaše Korisničko Ime: @include('back.layouts.partials.required-star')</label>
                                    <input type="text" name="username" class="form-control grey" value="{{ isset($customer) ? $customer->name : '' }}">
                                    @error('username')
                                    <div class="text-danger">Korisničko ime je obvezno...</div>
                                    @enderror
                                </div>
                            </div>

                            <legend style="margin-top: 45px;">Dodatni info</legend>
                            <div class="form-group clearfix ">
                                <div class="col-md-12">
                                    <label>Bio:</label>
                                    <textarea rows="8" class="form-control grey" name="message_content" >{{ isset($customer->details) ? $customer->details->bio : '' }}</textarea>
                                </div>
                            </div>
                        </fieldset>
                        <div class="buttons clearfix text-right">
                            <input type="submit" value="Dalje" class="btn btn-contrast">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
@endpush

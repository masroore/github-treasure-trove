@extends('layouts.frontend')

@section('content')
<div class="container">
    @include('includes.cart_links')    

    <div class="row mb-5">
        <h1 class="col-12 text-center mb-5">Shipping Information</h1>

        <form role="form" action="{{ route('payment') }}" method="post" class="require-validation">
            <div class="col-lg-8 mt-lg-3" style="float:left;">
                
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-floating">
                                <input type="text" class="form-control" name="first_name" required id="nameInput" value="{{($tempcustomer && isset($tempcustomer->first_name)) ? $tempcustomer->first_name : ''}}" placeholder="First Name">
                                <label for="nameInput">First Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-floating">
                                <input type="text" name="last_name" required value="{{($tempcustomer && isset($tempcustomer->last_name)) ? $tempcustomer->last_name : ''}}" class="form-control" name="first_name" id="nameLastInput" placeholder="Last Name">
                                <label for="nameLastInput">Last Name</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group form-floating">
                                <input type="text" class="form-control" required id="address1Input" value="{{($tempcustomer && isset($tempcustomer->address_1)) ? $tempcustomer->address_1 : ''}}" name="address_1" placeholder="Address 1">
                                <label for="address1Input">Address 1</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-floating">
                                <input type="text" name="address_2" required value="{{($tempcustomer && isset($tempcustomer->address_2)) ? $tempcustomer->address_2 : ''}}" class="form-control" name="address_2" id="address2Input" placeholder="Address 2">
                                <label for="address2Input">Address 2</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group form-floating">
                                <input type="text" class="form-control" required id="emailInput" value="{{($tempcustomer && isset($tempcustomer->email)) ? $tempcustomer->email : ''}}" name="email" placeholder="Email">
                                <label for="emailInput">Email</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-floating">
                                <input type="text" name="phone" required value="{{($tempcustomer && isset($tempcustomer->phone)) ? $tempcustomer->phone : ''}}" class="form-control" name="phone" id="phoneInput" placeholder="Phone">
                                <label for="phoneInput">Phone</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group form-floating">
                                <select class="form-control" name="shipping_country_name" required>
                                    <option selected value="US">US</option>
                                </select>
                                <label for="shipping_country_nameInput">Country</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group form-floating">
                                <input type="text" class="form-control" name="region" required value="{{($tempcustomer && isset($tempcustomer->payment_region)) ? $tempcustomer->payment_region : ''}}" id="regionInput" placeholder="Region">
                                <label for="regionInput">Region</label>
                            </div>
                        </div>
                       
                        <div class="col-md-6">
                            <div class="form-group form-floating">
                                <input type="text" class="form-control" name="city" required value="{{($tempcustomer && isset($tempcustomer->payment_city)) ? $tempcustomer->payment_city : ''}}" id="cityInput" placeholder="City">
                                <label for="cityInput">City </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group form-floating">
                                <input type="text" class="form-control" name="postcode" required value="{{($tempcustomer && isset($tempcustomer->postcode)) ? $tempcustomer->postcode : ''}}" id="postcodeInput" placeholder="Postcode">
                                <label for="postcodeInput">Postcode</label>
                            </div>
                        </div>
                    </div>
                
            </div>
            <div class="col-lg-4 mt-4 mt-lg-auto mb-3 order-summary-wrapper">
                <div class="d-flex mb-2"><span class="mr-auto">Total price</span>{{$final_price}}$</div>
                <!-- <div class="d-flex mb-3"><span class="mr-auto">Promocode</span>-10%</div> -->
                <div class="d-flex order-summary-total"><span class="mr-auto">Total price</span><span class="value">{{$final_price}}$</span></div>
                <!-- <a href="{{route('payment')}}" title="Delivery" class="btn btn-primary text-uppercase w-100 mb-2">Proceed to checkout</a> -->

                <button type="submit" class="btn btn-primary text-uppercase w-100 mb-2">Proceed to checkout</button>

                <a href="{{route('store')}}" title="Continue shopping" class="btn btn-outline-secondary text-uppercase w-100">Continue shopping</a>
            </div>
        </form>
    </div>
</div>

@endsection
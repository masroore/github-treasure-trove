@extends('layouts.app')

@section('content')
<section class="our-checkout-area bg__white">
            <div class="container">
                <div class="row">
                    
                        <div class="ckeckout-left-sidebar">
                            <!-- Start Checkbox Area -->
                            <div class="checkout-form">

                                <form role="form" action="{{ route('stripe.pay') }}" method="post" class="require-validation">
                                @csrf

                                <h2 class="section-title-3">Billing details @if($final_price) (${{$final_price}}) @endif</h2>
                                <div class="checkout-form-inner">
                                    <div class="single-checkout-box">
                                        <input type="text" required placeholder="First Name*" value="{{($tempcustomer && isset($tempcustomer->first_name)) ? $tempcustomer->first_name : ''}}" name="first_name">
                                        <input type="text" required placeholder="Last Name*" value="{{($tempcustomer && isset($tempcustomer->last_name)) ? $tempcustomer->last_name : ''}}" name="last_name">
                                    </div>
                                    <div class="single-checkout-box">
                                        <input type="text" required placeholder="Address 1*" value="{{($tempcustomer && isset($tempcustomer->address_1)) ? $tempcustomer->address_1 : ''}}" name="address_1">
                                        <input type="text" required placeholder="Address 2*" value="{{($tempcustomer && isset($tempcustomer->address_2)) ? $tempcustomer->address_2 : ''}}" name="address_2">
                                    </div>
                                    <div class="single-checkout-box">
                                        <input type="email" required placeholder="Email*" value="{{($tempcustomer && isset($tempcustomer->email)) ? $tempcustomer->email : ''}}" name="email">
                                        <input type="text" required placeholder="Phone*" value="{{($tempcustomer && isset($tempcustomer->phone)) ? $tempcustomer->phone : ''}}" name="phone">
                                    </div>
                                   
                                    <div class="single-checkout-box select-option">
                                        <select name="shipping_country_name" required>
                                            <option value="">Select Country</option>
                                            <option selected value="US">US</option>
                                        </select>
                                        <input type="text" value="{{($tempcustomer && isset($tempcustomer->region)) ? $tempcustomer->region : ''}}" placeholder="Region*" name="region">
                                    </div>
                                    <div class="single-checkout-box">
                                        <input type="text" placeholder="City*" value="{{($tempcustomer && isset($tempcustomer->shipping_city)) ? $tempcustomer->shipping_city : ''}}" name="city">
                                        <input type="text" placeholder="Postcode*" value="{{($tempcustomer && isset($tempcustomer->postcode)) ? $tempcustomer->postcode : ''}}" name="postcode">
                                    </div>
                                     <div class="single-checkout-box">
                                        <textarea name="comment" placeholder="Comments">{{($tempcustomer && isset($tempcustomer->comment)) ? $tempcustomer->comment : ''}}</textarea>
                                       
                                    </div>
                                    <!--<div class="single-checkout-box checkbox">
                                        <input id="remind-me" type="checkbox">
                                        <label for="remind-me"><span></span>Create a Account ?</label>
                                    </div>-->
                                </div>
                                <div class="contact-btn">
                                    <button type="submit" class="fv-btn">Make Payment @if($final_price) (${{$final_price}}) @endif</button>
                                </div>
                            </form>

                            </div>
                          
                        </div>
                    
                </div>
            </div>
        </section>
@endsection
@section('ext_js')
    
@endsection
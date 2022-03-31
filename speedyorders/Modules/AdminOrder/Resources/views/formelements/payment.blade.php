<div class="form-group {{ $errors->has('payment_first_name') ? 'has-error' : ''}} payment_fields">
    
    <input type="checkbox" name="same_as_customer_details" id="same_as_customer_details" value="1">&nbsp;
    <label for="copy" class="control-label">{{ ' Same As Customer Details ' }}</label>
</div>

<div class="form-group {{ $errors->has('payment_first_name') ? 'has-error' : ''}} payment_fields">
    <label for="payment_first_name" class="control-label">{{ ' First Name ' }}</label>
    <input class="form-control" type="text" name="payment_first_name" id="payment_first_name" value="{{ isset($order->payment_first_name) ? $order->payment_first_name : old('payment_first_name')}}">

    {!! $errors->first('payment_first_name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('payment_last_name') ? 'has-error' : ''}} payment_fields">
    <label for="payment_last_name" class="control-label">{{ ' Last Name ' }}</label>
    <input class="form-control" type="text" name="payment_last_name" id="payment_last_name" value="{{ isset($order->payment_last_name) ? $order->payment_last_name : old('payment_last_name')}}">

    {!! $errors->first('payment_last_name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('payment_company') ? 'has-error' : ''}} payment_fields">
    <label for="payment_company" class="control-label">{{ ' Company' }}</label>
    <input class="form-control" type="text" name="payment_company" id="payment_company" value="{{ isset($order->payment_company) ? $order->payment_company : old('payment_company')}}">

    {!! $errors->first('payment_company', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('payment_address_1') ? 'has-error' : ''}} payment_fields">
    <label for="payment_address_1" class="control-label">{{ ' Address 1 ' }}</label>
    <input class="form-control" type="text" name="payment_address_1" id="payment_address_1" value="{{ isset($order->payment_address_1) ? $order->payment_address_1 : old('payment_address_1')}}">

    {!! $errors->first('payment_address_1', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('payment_address_2') ? 'has-error' : ''}} payment_fields">
    <label for="payment_address_2" class="control-label">{{ ' Address 2' }}</label>
    <input class="form-control" type="text" name="payment_address_2" id="payment_address_2" value="{{ isset($order->payment_address_2) ? $order->payment_address_2 : old('payment_address_2')}}">

    {!! $errors->first('payment_address_2', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('payment_city') ? 'has-error' : ''}} payment_fields">
    <label for="payment_city" class="control-label">{{ ' City ' }}</label>
    <input class="form-control" type="text" name="payment_city" id="payment_city" value="{{ isset($order->payment_city) ? $order->payment_city : old('payment_city')}}">

    {!! $errors->first('payment_city', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('payment_postcode') ? 'has-error' : ''}} payment_fields">
    <label for="payment_postalcode" class="control-label">{{ ' Postalcode ' }}</label>
    <input class="form-control" type="text" name="payment_postcode" id="payment_postcode" value="{{ isset($order->payment_postcode) ? $order->payment_postcode : old('payment_postcode')}}">

    {!! $errors->first('payment_postcode', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('payment_country_name') ? 'has-error' : ''}} payment_fields">
    <label for="payment_country_name" class="control-label">{{ ' Country ' }}</label>
    <input class="form-control" type="text" name="payment_country_name" id="payment_country_name" value="{{ isset($order->payment_country_name) ? $order->payment_country_name : old('payment_country_name')}}">

    {!! $errors->first('payment_country_name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('payment_region') ? 'has-error' : ''}} payment_fields">
    <label for="payment_region" class="control-label">{{ ' Region ' }}</label>
    <input class="form-control" type="text" name="payment_region" id="payment_region" value="{{ isset($order->payment_region) ? $order->payment_region : old('payment_region')}}">

    {!! $errors->first('payment_region', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('payment_method') ? 'has-error' : ''}} payment_fields">
    <label for="payment_method" class="control-label">{{ ' Method ' }}</label>
    <input class="form-control" type="text" name="payment_method" id="payment_method" value="{{ isset($order->payment_method) ? $order->payment_method : old('payment_method')}}">

    {!! $errors->first('payment_method', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('payment_unique_code') ? 'has-error' : ''}} payment_fields">
    <label for="payment_unique_code" class="control-label">{{ ' Unique Code' }}</label>
    <input class="form-control" type="text" name="payment_unique_code" id="payment_unique_code" value="{{ isset($order->payment_unique_code) ? $order->payment_unique_code : old('payment_unique_code')}}">

    {!! $errors->first('payment_unique_code', '<p class="help-block">:message</p>') !!}
</div>
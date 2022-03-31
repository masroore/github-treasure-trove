<div class="form-group {{ $errors->has('payment_first_name') ? 'has-error' : ''}}">
    
    <input type="checkbox" name="same_as_customer_details_shipping" id="same_as_customer_details_shipping" value="1">&nbsp;
    <label for="copy" class="control-label">{{ ' Same As Customer Details ' }}</label>
</div>

<div class="form-group {{ $errors->has('shipping_first_name') ? 'has-error' : ''}}">
    <label for="shipping_first_name" class="control-label">{{ 'First Name *' }}</label>
    <input class="form-control" type="text" name="shipping_first_name" id="shipping_first_name" value="{{ isset($order->shipping_first_name) ? $order->shipping_first_name : old('shipping_first_name')}}">

    {!! $errors->first('shipping_first_name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('shipping_last_name') ? 'has-error' : ''}}">
    <label for="shipping_last_name" class="control-label">{{ 'Last Name *' }}</label>
    <input class="form-control" type="text" name="shipping_last_name" id="shipping_last_name" value="{{ isset($order->shipping_last_name) ? $order->shipping_last_name : old('shipping_last_name')}}">

    {!! $errors->first('shipping_last_name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('shipping_company') ? 'has-error' : ''}}">
    <label for="shipping_company" class="control-label">{{ 'Company' }}</label>
    <input class="form-control" type="text" name="shipping_company" id="shipping_company" value="{{ isset($order->shipping_company) ? $order->shipping_company : old('shipping_company')}}">

    {!! $errors->first('shipping_company', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('shipping_address_1') ? 'has-error' : ''}}">
    <label for="shipping_address_1" class="control-label">{{ 'Address1 *' }}</label>
    <input class="form-control" type="text" name="shipping_address_1" id="shipping_address_1" value="{{ isset($order->shipping_address_1) ? $order->shipping_address_1 : old('shipping_address_1')}}">

    {!! $errors->first('shipping_address_1', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('shipping_address_2') ? 'has-error' : ''}}">
    <label for="shipping_address_2" class="control-label">{{ 'Address2' }}</label>
    <input class="form-control" type="text" name="shipping_address_2" id="shipping_address_2" value="{{ isset($order->shipping_address_2) ? $order->shipping_address_2 : old('shipping_address_2')}}">

    {!! $errors->first('shipping_address_2', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('shipping_city') ? 'has-error' : ''}}">
    <label for="shipping_city" class="control-label">{{ 'City *' }}</label>
    <input class="form-control" type="text" name="shipping_city" id="shipping_city" value="{{ isset($order->shipping_city) ? $order->shipping_city : old('shipping_city')}}">

    {!! $errors->first('shipping_city', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('shipping_country_name') ? 'has-error' : ''}}">
    <label for="shipping_country_name" class="control-label">{{ 'Country *' }}</label>
    <input class="form-control" type="text" name="shipping_country_name" id="shipping_country_name" value="{{ isset($order->shipping_country_name) ? $order->shipping_country_name : old('shipping_country_name')}}">

    {!! $errors->first('shipping_country_name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('shipping_postcode') ? 'has-error' : ''}}">
    <label for="shipping_postcode" class="control-label">{{ 'Postalcode *' }}</label>
    <input class="form-control" type="text" name="shipping_postcode" id="shipping_postcode" value="{{ isset($order->shipping_postcode) ? $order->shipping_postcode : old('shipping_postcode')}}">

    {!! $errors->first('shipping_postcode', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('shipping_region') ? 'has-error' : ''}}">
    <label for="shipping_region" class="control-label">{{ 'Region *' }}</label>
    <input class="form-control" type="text" name="shipping_region" id="shipping_region" value="{{ isset($order->shipping_region) ? $order->shipping_region : old('shipping_region')}}">

    {!! $errors->first('shipping_region', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('shipping_method') ? 'has-error' : ''}}">
    <label for="shipping_method" class="control-label">{{ 'Method *' }}</label>
    <input class="form-control" type="text" name="shipping_method" id="shipping_method" value="{{ isset($order->shipping_method) ? $order->shipping_method : old('shipping_method')}}">

    {!! $errors->first('shipping_method', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('shipping_unique_code') ? 'has-error' : ''}}">
    <label for="shipping_unique_code" class="control-label">{{ 'Unique Code *' }}</label>
    <input class="form-control" type="text" name="shipping_unique_code" id="shipping_unique_code" value="{{ isset($order->shipping_unique_code) ? $order->shipping_unique_code : old('shipping_unique_code')}}">

    {!! $errors->first('shipping_unique_code', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('shipping_tracking_code') ? 'has-error' : ''}}">
    <label for="shipping_tracking_code" class="control-label">{{ 'Tracking Code *' }}</label>
    <input class="form-control" type="text" name="shipping_tracking_code" id="shipping_tracking_code" value="{{ isset($order->shipping_tracking_code) ? $order->shipping_tracking_code : old('shipping_tracking_code')}}">

    {!! $errors->first('shipping_tracking_code', '<p class="help-block">:message</p>') !!}
</div>
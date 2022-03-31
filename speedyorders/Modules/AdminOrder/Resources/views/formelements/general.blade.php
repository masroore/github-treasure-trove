        <div class="form-group">
            <label class="control-label">Choose Existing Customer</label>
                <select name="customer_user_id" class="form-control js-dropdown-select2" id="customer_id">
                    <option value="" selected>Select any customer</option>
                        @foreach ($customers as $row=>$customer)
                            <option value="{{ $customer->id }}" {{isset($order)?($order->customer_user_id == $customer->id)?'selected':'':''}}>{{ $customer->email }}</option>
                        @endforeach
                </select>
        </div>

        <div class="form-group {{ $errors->has('user_email') ? 'has-error' : ''}}">
            <label class="control-label">New User Email</label>
            <input class="form-control" type="text" name="user_email" id="user_email" value="{{ isset($order->user_email) ? $order->user_email : old('user_email') }}">
            {!! $errors->first('user_email', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('invoice_number') ? 'has-error' : ''}}">
            <label for="invoice_number" class="control-label">{{ 'Invoice Number *' }}</label>
            <input class="form-control" type="text" name="invoice_number" id="invoice_number" value="{{ isset($order->invoice_number) ? $order->invoice_number : \Str::random(10)}}" readonly>
            {!! $errors->first('invoice_number', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('invoice_prefix') ? 'has-error' : ''}}">
            <label for="invoice_prefix" class="control-label">{{ 'Invoice Prefix *' }}</label>
            <input class="form-control" type="text" name="invoice_prefix" id="invoice_prefix" value="{{ isset($order->invoice_prefix) ? $order->invoice_prefix : old("invoice_prefix")}}">

            {!! $errors->first('invoice_prefix', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
            <label for="first_name" class="control-label">{{ 'First Name *' }}</label>
            <input class="form-control" type="text" name="first_name" id="first_name" value="{{ isset($order->first_name) ? $order->first_name : old('first_name')}}">

            {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
            <label for="last_name" class="control-label">{{ 'Last Name *' }}</label>
            <input class="form-control" type="text" name="last_name" id="last_name" value="{{ isset($order->last_name) ? $order->last_name : old('last_name')}}">

            {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('address_1') ? 'has-error' : ''}}">
            <label for="address_1" class="control-label">{{ 'Address1 *' }}</label>
            <input class="form-control" type="text" name="address_1" id="address_1" value="{{ isset($order->address_1) ? $order->address_1 : old('address_1')}}">

            {!! $errors->first('address_1', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('address_2') ? 'has-error' : ''}}">
            <label for="address_2" class="control-label">{{ 'Address2' }}</label>
            <input class="form-control" type="text" name="address_2" id="address_2" value="{{ isset($order->address_2) ? $order->address_2 : old('address_2')}}">

            {!! $errors->first('address_2', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('city') ? 'has-error' : ''}} ">
            <label for="city" class="control-label">{{ ' City ' }}</label>
            <input class="form-control" type="text" name="city" id="city" value="{{ isset($order->city) ? $order->city : old('city')}}">

            {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('country_name') ? 'has-error' : ''}}">
            <label for="country_name" class="control-label">{{ ' Country ' }}</label>
            <input class="form-control" type="text" name="country_name" id="country_name" value="{{ isset($order->country_name) ? $order->country_name : old('country_name')}}">

            {!! $errors->first('country_name', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('postcode') ? 'has-error' : ''}}">
            <label for="postcode" class="control-label">{{ 'Post Code *' }}</label>
            <input class="form-control" type="text" name="postcode" id="postcode" value="{{ isset($order->postcode) ? $order->postcode : old('postcode')}}">

            {!! $errors->first('postcode', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
            <label for="email" class="control-label">{{ 'Email *' }}</label>
            <input class="form-control" type="text" name="email" id="email" value="{{ isset($order->email) ? $order->email : old('email')}}">

            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
        </div>
        
        <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
            <label for="phone" class="control-label">{{ 'Phone *' }}</label>
            <input class="form-control" type="text" name="phone" id="phone" value="{{ isset($order->phone) ? $order->phone : old('phone')}}">

            {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
        </div>
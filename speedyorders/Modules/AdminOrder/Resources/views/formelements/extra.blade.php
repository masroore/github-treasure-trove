<div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
    <label for="comment" class="control-label">{{ 'Comment' }}</label>
    <textarea class="form-control" rows="5" name="comment" type="textarea" id="comment">{{ isset($order->comment) ? $order->comment : old('comment')}}</textarea>
    {!! $errors->first('comment', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>
    <select name="status" class="form-control" id="status">
        @foreach (json_decode('{"1":"Active","0":"Inactive"}', true) as $optionKey => $optionValue)
            <option value="{{ $optionKey }}" {{ (isset($order->status) && $order->status == $optionKey) ? 'selected' : old('status')}}>{{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('commisison') ? 'has-error' : ''}}">
    <label for="commisison" class="control-label">{{ 'Commisison' }}</label>
    <input class="form-control" type="number" name="commisison" id="commisison" value="{{ isset($order->commisison) ? $order->commisison : old('commisison')}}">

    {!! $errors->first('commisison', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('currency_code') ? 'has-error' : ''}}">
    <label for="currency_code" class="control-label">{{ 'Currency Code *' }}</label>
    <input class="form-control" type="text" name="currency_code" id="currency_code" value="{{ isset($order->currency_code) ? $order->currency_code : old('currency_code')}}">

    {!! $errors->first('currency_code', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('currency_value') ? 'has-error' : ''}}">
    <label for="currency_value" class="control-label">{{ 'Currency Value *' }}</label>
    <input class="form-control" type="number" name="currency_value" id="currency_value" value="{{ isset($order->currency_value) ? $order->currency_value : old('currency_value')}}">

    {!! $errors->first('currency_value', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('ip') ? 'has-error' : ''}}">
    <label for="ip" class="control-label">{{ 'Ip' }}</label>
    <input class="form-control" type="text" name="ip" id="ip" value="{{ isset($order->ip) ? $order->ip : old('ip')}}">

    {!! $errors->first('ip', '<p class="help-block">:message</p>') !!}
</div>
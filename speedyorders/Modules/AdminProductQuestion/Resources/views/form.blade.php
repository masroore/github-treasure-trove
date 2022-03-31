<div class="form-group {{ $errors->has('product_id') ? 'has-error' : ''}}">
    <label for="product_id" class="control-label">{{ 'Product' }}</label>
    <select class="form-control js-dropdown-select2" type="number" name="product_id" id="product_id" required>
        @foreach ($products as $optionValue)
            <option value="{{ $optionValue->id }}" {{ (isset($productquestion->product_id) && $productquestion->product_id == $optionValue->id) ? 'selected' : ''}}>{{ $optionValue->name }}</option>
        @endforeach
    </select>
    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('customer_id') ? 'has-error' : ''}}">
    <label for="customer_id" class="control-label">{{ 'Customer' }}</label>
    <input class="form-control" type="number" name="customer_id" id="customer_id" value="{{ isset($productquestion->customer_id) ? $productquestion->customer_id : ''}}"> </input>

    {!! $errors->first('customer_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Name' }}</label>
    <input class="form-control" type="text" name="name" id="name" value="{{ isset($productquestion->name) ? $productquestion->name : ''}}" required> </input>

    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">{{ 'Description' }}</label>
    <textarea class="form-control" rows="5" name="description" type="textarea" id="description" required>{{ isset($productquestion->description) ? $productquestion->description : ''}}</textarea>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="control-label">{{ 'Email' }}</label>
    <input class="form-control" type="email" name="email" id="email" value="{{ isset($productquestion->email) ? $productquestion->email : ''}}" required> </input>

    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>
    <select name="status" class="form-control js-dropdown-select2" id="status" required>
    @foreach (json_decode('{"1":"Active","0":"Inactive"}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($productquestion->status) && $productquestion->status == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>




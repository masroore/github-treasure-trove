<div class="form-group {{ $errors->has('product_id') ? 'has-error' : ''}}">
    <label for="product_id" class="control-label">{{ 'Product Id' }}</label>
    <input class="form-control" type="number" name="product_id" id="product_id" value="{{ isset($review->product_id) ? $review->product_id : ''}}" required> </input>

    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('customer_id') ? 'has-error' : ''}}">
    <label for="customer_id" class="control-label">{{ 'Customer Id' }}</label>
    <input class="form-control" type="number" name="customer_id" id="customer_id" value="{{ isset($review->customer_id) ? $review->customer_id : ''}}" required> </input>

    {!! $errors->first('customer_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Name' }}</label>
    <input class="form-control" type="text" name="name" id="name" value="{{ isset($review->name) ? $review->name : ''}}" required> </input>

    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('review') ? 'has-error' : ''}}">
    <label for="review" class="control-label">{{ 'Review' }}</label>
    <textarea class="form-control" rows="5" name="review" type="textarea" id="review" required>{{ isset($review->review) ? $review->review : ''}}</textarea>
    {!! $errors->first('review', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('rating') ? 'has-error' : ''}}">
    <label for="rating" class="control-label">{{ 'Rating' }}</label>
    <select name="rating" class="form-control" id="rating" required>
    @foreach (json_decode('{"1":"1","2":"2","3":"3","4":"4","5":"5"}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($review->rating) && $review->rating == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('rating', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>
    <select name="status" class="form-control" id="status" required>
    @foreach (json_decode('{"1":"Active","0":"Inactive"}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($review->status) && $review->status == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>

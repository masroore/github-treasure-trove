<div class="form-group {{ $errors->has('product_id') ? 'has-error' : ''}}">
    <label for="product_id" class="control-label">{{ 'Product' }}</label>

    <select name="product_id" class="form-control js-dropdown-select2" id="product_id" required>
    @foreach ($products as $optionKey => $optionValue)
        <option value="{{ $optionValue->id }}" {{ (isset($review->product_id) && $review->product_id == $optionValue->id) ? 'selected' : ''}}>{{ $optionValue->name }}</option>
    @endforeach
</select>
    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('author') ? 'has-error' : ''}}">
    <label for="author" class="control-label">{{ 'Customer Name' }}</label>
    <input class="form-control" type="text" name="author" id="author" value="{{ isset($review->author) ? $review->author : ''}}" required> </input>

    {!! $errors->first('author', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('text') ? 'has-error' : ''}}">
    <label for="text" class="control-label">{{ 'Review' }}</label>
    <textarea class="form-control" rows="5" name="text" type="textarea" id="text" required>{{ isset($review->text) ? $review->text : ''}}</textarea>
    {!! $errors->first('text', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('rating') ? 'has-error' : ''}}">
    <label for="rating" class="control-label">{{ 'Rating' }}</label>
    <select name="rating" class="form-control" id="rating" required>
    @foreach (json_decode('{"5":"5","1":"1","2":"2","3":"3","4":"4"}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($review->rating) && $review->rating == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('rating', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>
    <select name="status" class="form-control js-dropdown-select2" id="status" required>
    @foreach (json_decode('{"1":"Active","0":"Inactive"}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($review->status) && $review->status == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Name' }}</label>
    <input class="form-control" type="text" name="name" id="name" value="{{ isset($faqcategory->name) ? $faqcategory->name : ''}}" required> </input>

    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('meta-tag') ? 'has-error' : ''}}">
    <label for="meta-tag" class="control-label">{{ 'Meta-tag' }}</label>
    <input class="form-control" type="text" name="meta_tag" id="meta-tag" value="{{ isset($faqcategory->meta_tag) ? $faqcategory->meta_tag : ''}}" required> </input>

    {!! $errors->first('meta-tag', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('sort_order') ? 'has-error' : ''}}">
    <label for="sort_order" class="control-label">{{ 'Sort Order' }}</label>
    <input class="form-control" type="text" name="sort_order" id="sort_order" value="{{ isset($faqcategory->sort_order) ? $faqcategory->sort_order : ''}}" required> </input>

    {!! $errors->first('sort_order', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>
    <select name="status" class="form-control" id="status" required>
    @foreach (json_decode('{"1":"Active","0":"Inactive"}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($faqcategory->status) && $faqcategory->status == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>


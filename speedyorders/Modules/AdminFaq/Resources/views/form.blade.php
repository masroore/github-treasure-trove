<div class="form-group {{ $errors->has('faq_category_id') ? 'has-error' : ''}}">
    <label for="faq_category_id" class="control-label">{{ 'Category Id' }}</label>
     <select name="faq_category_id" class="form-control js-dropdown-select2" id="faq_category" required>
        @foreach ($categories as $optionValue)
            <option value="{{ $optionValue->id }}" {{ (isset($faq->faq_category_id) && $faq->faq_category_id == $optionValue->id) ? 'selected' : ''}}>{{ $optionValue->name }}</option>
        @endforeach
    </select>
    {!! $errors->first('faq_category_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('faq_category_id') ? 'has-error' : ''}}">
    <label for="faq_category_id" class="control-label">{{ 'Type' }}</label>
     <select name="type" class="form-control js-dropdown-select2" id="type" required>
        
        <option value="faq" {{ (isset($faq->type) && $faq->type == 'faq') ? 'selected' : ''}}>FAQ</option>
        <option value="support" {{ (isset($faq->type) && $faq->type == 'support') ? 'selected' : ''}}>Support</option>
        
    </select>
    {!! $errors->first('faq_category_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('question') ? 'has-error' : ''}}">
    <label for="question" class="control-label">{{ 'Question' }}</label>
    <input class="form-control" type="text" name="question" id="question" value="{{ isset($faq->question) ? $faq->question : ''}}" required> </input>

    {!! $errors->first('question', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('answer') ? 'has-error' : ''}}">
    <label for="answer" class="control-label">{{ 'Answer' }}</label>
    <textarea class="form-control" name="answer" id="answer" cols="30" rows="10">{{ isset($faq->answer) ? $faq->answer : ''}}</textarea>

    {!! $errors->first('answer', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('sort_order') ? 'has-error' : ''}}">
    <label for="sort_order" class="control-label">{{ 'Sort Order' }}</label>
    <input class="form-control" type="number" name="sort_order" id="sort_order" value="{{ isset($faq->sort_order) ? $faq->sort_order : ''}}" required> </input>

    {!! $errors->first('sort_order', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>
    <select name="status" class="form-control js-dropdown-select2" id="status" required>
    @foreach (json_decode('{"1":"Active","0":"Inactive"}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($faq->status) && $faq->status == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>


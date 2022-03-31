
<div class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
    <label for="category_id" class="control-label">{{ 'Parent Category' }}</label>
    <select name="category_id" class="form-control js-dropdown-select2" id="category_id" >
        <option value="">Select parent Category</option>
        @foreach ($categories as $optionValue)
            <option value="{{ $optionValue->id }}" {{ (isset($category->category_id) && $category->category_id == $optionValue->id) ? 'selected' : ''}}>{{ $optionValue->parentCategories }}</option>
        @endforeach
    </select>
    {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Name' }}<span class="error">*</span></label>
    <input class="form-control" type="text" name="name" id="name" value="{{ old('name', isset($category->name) ? $category->name : null) }}" > </input>

    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('slug') ? 'has-error' : ''}}">
    <label for="slug" class="control-label">{{ 'Slug' }}</label>
    <input class="form-control" type="text" name="slug" id="slug" value="{{ old('slug', isset($category->slug) ? $category->slug : null) }}" > </input>

    {!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
    <label for="image" class="control-label">{{ 'Image' }}</label>
    <input type="file" name="image" class="form-control">
    {!! $errors->first('image', '<p class="help-block">:message</p>') !!}

    @if(isset($category->image)  && $category->image!='')
        <br>
        <span id="categoryImage">
            <img width="250" src="{{url('images/categories/'.$category->image)}}">    
        </span>
    @endif
</div>


<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">{{ 'Description' }}<span class="error">*</span></label>
    <textarea class="form-control" rows="5" name="description" type="textarea" id="description" >{{ old('description', isset($category->description) ? $category->description : null) }}</textarea>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('return_policy') ? 'has-error' : ''}}">
    <label for="return_policy" class="control-label">{{ 'Return Policy' }}<span class="error">*</span></label>
    <textarea class="form-control" rows="5" name="return_policy" type="textarea" id="return_policy" >{{ old('return_policy', isset($category->return_policy) ? $category->return_policy : null) }}</textarea>
    {!! $errors->first('return_policy', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('is_featured') ? 'has-error' : ''}}">
    <label for="is_featured" class="control-label">{{ 'Featured' }}</label>
    <select name="is_featured" class="form-control js-dropdown-select2" id="is_featured" >
    @php
        $is_featured = [1=>'Featured',0=>'Not-Featured'];
    @endphp
    @foreach ( $is_featured as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($category->is_featured) && $category->is_featured == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('is_featured', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('sort_order') ? 'has-error' : ''}}">
    <label for="sort_order" class="control-label">{{ 'Sort Order' }}</label>
    <input class="form-control" type="text" name="sort_order" id="sort_order" value="{{ isset($category->sort_order) ? $category->sort_order : ''}}" > </input>

    {!! $errors->first('sort_order', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('show_on_homepage') ? 'has-error' : ''}}">
    <label for="show_on_homepage" class="control-label">{{ 'Show on Homepage' }}</label>
    <select name="show_on_homepage" class="form-control js-dropdown-select2" id="show_on_homepage" >
    @php
        $show_on_homepage = [1=>'Yes',0=>'No'];
    @endphp
    @foreach ( $show_on_homepage as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($category->show_on_homepage) && $category->show_on_homepage == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('show_on_homepage', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>
    <select name="status" class="form-control js-dropdown-select2" id="status" >
    @php
        $status = [1=>'Active',0=>'Passive'];
    @endphp
    @foreach ( $status as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($category->status) && $category->status == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>

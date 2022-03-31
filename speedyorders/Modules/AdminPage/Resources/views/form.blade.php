<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : ''}}">
    <label for="parent_id" class="control-label">{{ 'Parent Id' }}</label>

    <select name="parent_id" class="form-control js-dropdown-select2" id="parent_id">
         <option value="" selected>Select Parent</option>
        @foreach ($pages as $optionValue)
            <option value="{{ $optionValue->id }}" {{ (isset($adminpage->parent_id) && $adminpage->parent_id == $optionValue->id) ? 'selected' : ''}}>{{ $optionValue->title }}</option>
        @endforeach
    </select>
    {!! $errors->first('parent_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('slug') ? 'has-error' : ''}}">
    <label for="slug" class="control-label">{{ 'Slug' }}</label>
    <input class="form-control" type="text" name="slug" id="slug" value="{{ isset($adminpage->slug) ? $adminpage->slug : ''}}" required> </input>

    {!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ 'Title' }}</label>
    <input class="form-control" type="text" name="title" id="title" value="{{ isset($adminpage->title) ? $adminpage->title : ''}}" required> </input>

    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
    <label for="content" class="control-label">{{ 'Content' }}</label>
    <textarea class="form-control" name="content" id="content" cols="30" rows="10">
        {{ isset($adminpage->content) ? $adminpage->content : ''}}
    </textarea>
    {!! $errors->first('content', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('main_image') ? 'has-error' : ''}}">
    <label for="main_image" class="control-label">{{ 'Main Image' }}</label>
    <input class="form-control" type="text" name="main_image" id="main_image" value="{{ isset($adminpage->main_image) ? $adminpage->main_image : ''}}" required> </input>

    {!! $errors->first('main_image', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('main_video') ? 'has-error' : ''}}">
    <label for="main_video" class="control-label">{{ 'Main Video' }}</label>
    <input class="form-control" type="text" name="main_video" id="main_video" value="{{ isset($adminpage->main_video) ? $adminpage->main_video : ''}}" required> </input>

    {!! $errors->first('main_video', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('seo') ? 'has-error' : ''}}">
    <label for="seo" class="control-label">{{ 'Seo' }}</label>
    <input class="form-control" type="text" name="seo" id="seo" value="{{ isset($adminpage->seo) ? $adminpage->seo : ''}}" required> </input>

    {!! $errors->first('seo', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('seo_description') ? 'has-error' : ''}}">
    <label for="seo_description" class="control-label">{{ 'Seo Description' }}</label>
    <textarea class="form-control" name="seo_description" id="seo_description"  cols="30" rows="10">
        {{ isset($adminpage->seo_description) ? $adminpage->seo_description : ''}}
    </textarea>
    {!! $errors->first('seo_description', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('sort_order') ? 'has-error' : ''}}">
    <label for="sort_order" class="control-label">{{ 'Sort Order' }}</label>
    <input class="form-control" type="number" name="sort_order" id="sort_order" value="{{ isset($adminpage->sort_order) ? $adminpage->sort_order : ''}}" required> </input>

    {!! $errors->first('sort_order', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>
    <select name="status" class="form-control js-dropdown-select2" id="status" required>
    @foreach (json_decode('{"1":"Active","0":"Inactive"}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($adminpage->status) && $adminpage->status == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>


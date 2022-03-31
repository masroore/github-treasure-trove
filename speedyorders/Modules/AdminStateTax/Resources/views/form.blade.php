
<div class="form-group {{ $errors->has('state_code') ? 'has-error' : ''}}">
    <label for="state_code" class="control-label">{{ 'State Code' }}</label>
    <input class="form-control" type="text" name="state_code" id="state_code" value="{{ old('state_code', isset($tax->state_code) ? $tax->state_code : null) }}" > </input>

    {!! $errors->first('state_code', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('tax_percentage') ? 'has-error' : ''}}">
    <label for="slug" class="control-label">{{ 'Tax Percentage' }}</label>
    <input class="form-control" type="text" name="tax_percentage" id="tax_percentage" value="{{ old('tax_percentage', isset($tax->tax_percentage) ? $tax->tax_percentage : null) }}" > </input>

    {!! $errors->first('tax_percentage', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group {{ $errors->has('is_default') ? 'has-error' : ''}}">
    <label for="is_default" class="control-label">{{ 'Default' }}</label>
    <select name="is_default" class="form-control js-dropdown-select2" id="is_default" >
    @php
        $status = [0=>'No', 1=>'Yes'];
    @endphp
    @foreach ( $status as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($tax->is_default) && $tax->is_default == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('is_default', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>

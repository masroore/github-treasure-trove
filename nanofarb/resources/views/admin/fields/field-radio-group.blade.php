<div class="form-group {{ $errors->has('path') ? 'has-error' : ''}}">
    @php
        $field_name = isset($field_name) ? $field_name : '';
    @endphp
    @foreach($attributes as $value => $label)
        <div class="">
            <input class="radio"
                   type="radio"
                   name="{{ $field_name }}"
                   id="{{ $field_name.$loop->index }}"
                   value="{{ $value }}"
                   @if($selected == $value) checked="" @endif
            >
            @isset($label)<label for="{{ $field_name.$loop->index }}">{{ $label }}</label>@endisset
        </div>
    @endforeach
    {!! $errors->first( $field_name , '<p class="help-block">:message</p>') !!}
</div>

{{--
@include('admin.fields.field-radio-group', [
    'field_name' => 'path_type',
    'selected' => isset($menuItem) ? $menuItem->path_type : 1,
    'attributes' => [1 => 'URL-путь', 2 => 'URL-алиас',]
])
--}}

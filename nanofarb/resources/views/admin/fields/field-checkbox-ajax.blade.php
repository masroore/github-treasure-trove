{{-- TODO do js, blade --}}
<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    @php
        $field_name = isset($field_name) ? $field_name : '';
    @endphp
    <div class="">
        <input type="hidden" name="{{ $field_name }}" value="0">
        <input class="checkbox"
               type="checkbox"
               name="{{ $field_name }}"
               id="{{ $field_name }}"
               value="1"
               @if(old($field_name, $status ?? false)) checked @endif
        >
        <label for="{{ $field_name }}">{!! $label ?? 'Статус' !!}</label>
    </div>
    @isset($help_block) <p class="help-block small">{!! $help_block !!}</p>@endisset
    {!! $errors->first(str_replace_last('[]', '', $field_name), '<p class="help-block" style="color:red;">:message</p>') !!}
</div>

{{--
@include('admin.fields.field-checkbox-ajax', [
    'label' => 'Статус',
    'field_name' => 'status',
    'status' => 0,
    'url' => '',
])
--}}



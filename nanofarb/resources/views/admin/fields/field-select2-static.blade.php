<div class="form-group">
    <label class="control-label">{!! $label ?? 'Значения' !!}</label>
    @php
        $field_name = $field_name ?? '';
        $field_name_input = (isset($multiple) && $multiple) ? (str_replace_last('[]', '', $field_name) . '[]') : str_replace_last('[]', '', $field_name);
    @endphp

    @php
        $selected = isset($selected) ? (is_array($selected) ? $selected : [$selected]) : [];
        //$old = isset($old) ? (is_array($old) ? $old : [$old]) : [];
        $old = $old ?? old($field_name);
        $old = $old ? (is_array($old) ? $old: [$old]) : [];
        $selected = $old + $selected;
        $attributes = isset($attributes) && is_array($attributes) ? $attributes : [];
    @endphp

    <select
            name="{{ $field_name_input }}"
            class="form-control select2"
            @if(isset($multiple) && $multiple && (empty($max) || $max > 1)) multiple @endif
            @if(isset($disabled) && $disabled) disabled @endif
            @if(isset($required) && $required) required @endif
            style="width: 100%;"
            @if(count($attributes) < 6) data-minimum-results-for-search="-1" @endif
    >

        @if(empty($multiple) && count($attributes) > 6)
            <option value="" disabled selected> --- </option>
        @endif

        @if(isset($empty_value) && empty($multiple))
            <option value="" selected> {{ $empty_value }} </option>
        @endisset

        @foreach($attributes as $value => $title)
            <option value="{{ $value }}" @if(in_array($value, $selected)) selected @endif>{{ $title }}</option>
        @endforeach
    </select>
</div>
{!! $errors->first(str_replace_last('[]', '', $field_name), '<p class="help-block" style="color:red;">:message</p>') !!}

{{-- Select2 с статически загруженными данными--}}
{{--
@include('admin.fields.field-select2-static', [
    'label' => 'Значения атрибута "' . $attribute->title . '"',
    'field_name' => 'values['.$attribute->id.']',
    'multiple' => 0,
    'max' => 1,
    'disabled' => 0,
    'required' => 1,
    'attributes' => [1 => 'Новый заказ', 2 => 'В обработке'], //$attribute->values->pluck('value', 'id')->toArray(),
    'selected' => isset($product) ? $product->values->pluck('id')->toArray() : [],
    'empty_value' => '--не указано--',
])
--}}

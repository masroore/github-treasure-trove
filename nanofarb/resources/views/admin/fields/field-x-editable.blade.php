@php
    $value = isset($value) ? $value : null;
    $field_name = isset($field_name) ? $field_name : '';
    $label = isset($label) ? $label : '[значение]';
@endphp

<a href="#"
   class="field-x-editable"
   data-value="{{ $value }}"
   data-type="{{ isset($type) ? $type : 'text' }}"
   data-name="{{ $field_name }}"
   @isset($source)data-source="{{ json_encode($source) }}"@endisset
   @isset($url)data-url="{{ $url }}"@endisset
   @isset($pk)data-pk="{{ $pk }}"@endisset
> {{ $value ?: $label }}
</a>

{{--
 @include('admin.fields.field-editable', [
    'value' => $form->data['message'] ?? '[Вопрос]',
    'type' => 'textarea',
    'field_name' => 'data[message]',
    'pk' => $form->id,
    'url' => route('admin.forms.editable', $form),
])
--}}

{{--
@include('admin.fields.field-x-editable', [
    'value' => 1,
    'type' => 'select',
    'field_name' => 'data[show_if_empty_filter]',
    'source' => [["value" => "1", "text" => "Отображать"], ["value" => "0", "text" => "Скрывать"]],
    'pk' => $attribute->id,
    'url' => route('admin.shop.attributes.editable', $attribute),
])
--}}

@push('scripts')
    <script>
        $('a[data-type="select"]').editable({
            // prepend: "not selected",
            display: function(value, sourceData) {
                var colors = {"": "gray", "0": "gray", 1: "green", 2: "blue"},
                    elem = $.grep(sourceData, function(o){return o.value == value;});
                if(elem.length) {
                    $(this).text(elem[0].text).css("color", colors[value]);
                } else {
                    $(this).empty();
                }
            }
        });
    </script>
@endpush
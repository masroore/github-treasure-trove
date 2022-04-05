@php
    $field_laravel_name = trim(preg_replace('/[\]\[]/', '.', $field_name), '.');
    $items = $items ?? [];
    //$items = array_merge(old($field_laravel_name, []), ['qq' => 'Qq', 'ww' => 'Ww']); // TODO
    $placeholder_value = $placeholder_value ?? 'Значение';
@endphp

<div class="form-group field-list-items"
     data-field-name="{{ $field_name }}"
     data-placeholder-value="{{ $placeholder_value }}"
>
    <label>{{ $label ?? 'Пункты' }}</label>
    <div class="table-responsive">
        <table class="table table-striped">
            <tbody>
                @forelse($items as $item)
                <tr class="item first">
                    <td>
                        <div class="input-group input-group-md">
                            <span class="input-group-btn" style="width: 40%">
                                <input type="text" name="{{ $field_name }}[]" value="{!! $item ?? '' !!}" class="form-control" placeholder="{{ $placeholder_value .' '. $loop->iteration }}">
                            </span>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-info btn-flat">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-flat">
                                    <i class="fa fa-remove"></i>
                                </button>
                            </span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="item first">
                    <td>
                        <div class="input-group input-group-md">
                            <span class="input-group-btn" style="width: 40%">
                                 <input type="text" class="form-control" name="{{ $field_name}}[]" placeholder="{{ $placeholder_value }}">
                            </span>
                            </span>
                                <span class="input-group-btn">
                                <button type="button" class="btn btn-info btn-flat">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <button type="button" disabled class="btn btn-danger btn-flat">
                                    <i class="fa fa-remove"></i>
                                </button>
                            </span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {!! $errors->first($field_laravel_name, '<p class="help-block" style="color:red;">:message</p>') !!}
    </div>
</div>

{{--
@include('admin.fields.field-field-list-items', [
   'label' => 'Пример линейного списка',
   'field_name' => 'vars_json[phones]',
   'placeholder_value' => 'Значение',
   'items' => json_decode(variable('phones_header', '[]'), true),
])
--}}

@push('scripts')
    <script>
        if ($('.field-list-items').length) {
            $('.field-list-items').on('click', '.btn-info', function (e) {
                e.preventDefault()
                var n = $(this).parents('.field-list-items').find('.btn-info').index(this),
                    length = $(this).parents('.field-list-items').find('.btn-info').length,
                    fieldName = $(this).parents('.field-list-items').data('field-name'),
                    placeholderValue = $(this).parents('.field-list-items').data('placeholder-value'),
                    item = '<tr class="item">'
                        + '<td>'
                        + '<div class="input-group input-group-md">'
                        + '<span class="input-group-btn" style="width: 40%">'
                        + '<input type="text" name="' + fieldName + '[' + (length) + ']" class="form-control" placeholder="' + placeholderValue +' '+ (parseInt(length) + 1) + '">'
                        + '</span>'
                        + '<span class="input-group-btn">'
                        + '<button type="button" class="btn btn-info btn-flat">'
                        + '<i class="fa fa-plus"></i>'
                        + '</button>'
                        + '<button type="button" class="btn btn-danger btn-flat">'
                        + '<i class="fa fa-remove"></i>'
                        + '</button>'
                        + '</span>'
                        + '</div>'
                        + '</td>'
                        + '</tr>"'
                $(this).parents('.field-list-items').find('.item').eq(n).after(item)
            })

            $('.field-list-items').on('click', '.btn-danger', function (e) {
                e.preventDefault()
                var n = $(this).parents('.field-list-items').find('.btn-danger:not(.first)').index(this)

                $(this).parents('.field-list-items').find('.item').eq(n).remove()
            })
        }
    </script>
@endpush

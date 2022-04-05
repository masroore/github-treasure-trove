@php
    $field_laravel_name = trim(preg_replace('/[\]\[]/', '.', $field_name), '.');
    $items = $items ?? [];
    //$items = array_merge(old($field_laravel_name, []), ['qq' => 'Qq', 'ww' => 'Ww']); // TODO
    $key_key = $key_key ?? 'key';
    $key_value = $key_value ?? 'value';
    $placeholder_key = $placeholder_key ?? 'Ключ';
    $placeholder_value = $placeholder_value ?? 'Значение';
@endphp

<div class="form-group field-links"
     data-field-name="{{ $field_name }}"
     data-key="{{ $key_key }}"
     data-value="{{ $key_value }}"
     data-placeholder-key="{{ $placeholder_key }}"
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
                            <input type="text" class="form-control" @isset ($item['safe']) readonly @endisset name="{{ $field_name}}[{{$loop->index}}][{{$key_key}}]" value="{{ $item[$key_key] ?? '' }}" placeholder="{{ $placeholder_key }}">
                            <span class="input-group-btn" style="width: 40%">
                                <input type="text" name="{{ $field_name }}[{{ $loop->index }}][{{ $key_value }}]" value="{!! $item[$key_value] ?? '' !!}" class="form-control" placeholder="{{ $placeholder_value }}">
                                <input type="hidden" name="{{ $field_name }}[{{ $loop->index }}][safe]" value="1" @empty($item['safe']) disabled @endisset>
                            </span>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-info btn-flat">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <button type="button" @isset ($item['safe']) disabled @endisset class="btn btn-danger btn-flat">
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
                            <input type="text" class="form-control" name="{{ $field_name}}[0][{{$key_key}}]" placeholder="{{ $placeholder_key }}">
                            <span class="input-group-btn" style="width: 40%">
                                <input type="text" name="{{ $field_name }}[0][{{ $key_value }}]" class="form-control" placeholder="{{ $placeholder_value }}">
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
@include('admin.fields.field-links', [
   'label' => 'Способы доставки',
   'field_name' => 'vars_json[delivery_method]',
   'key_key' => 'key',
   'key_value' => 'value',
   'placeholder_key' => 'Ключ',
   'placeholder_value' => 'Значение',
   'items' => [['key' => 0, 'value' => 'Qwe', 'safe' => 1], ['key' => 1, 'value' => 'Rty']]
])
--}}

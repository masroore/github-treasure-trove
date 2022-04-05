<div class="form-group gallery field-more-items">
    <label>{!! $label ?? 'Изображения' !!}</label>
    @php
        $field_name_input = isset($field_name) ? (str_replace_last('[]', '', $field_name) . '[]') : '';
        $field_name_deleted = isset($field_name) ? (str_replace_last('[]', '', $field_name) . '_deleted[]') : '';
        $collection_name = isset($field_name) ? (str_replace_last('[]', '', $field_name)) : '';
    @endphp
    <input type="file" multiple name="{{ $field_name_input }}">
    {{--<p class="help-block">Максимальный размер изображений 5мБ</p>--}}
    @if(isset($entity) && $entity->getMedia($collection_name)->count())
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Название</th>
                    <th>Фото</th>
                    <th style="width: 40px">Действие</th>
                </tr>
            </thead>
            <tbody>
                @foreach($entity->getMedia($collection_name) as $image)
                <tr class="image-container">
                    <td>{{ $loop->iteration }}</td>
                    <td><a href="#" target="_blank">{{ str_limit($image->name, 20) }}</a></td>
                    <td>
                        <a href="{{ $image->getUrl('thumb') }}" target="_blank"><img src="{{ $image->getUrl('thumb') }}" alt=""></a>
                    </td>
                    <td>
                        <a href="" class="filed-remove btn btn-xs btn-danger" data-id="{{ $image->id }}"><i class="fa fa-remove"></i></a>
                        <input type="hidden" name="{{ $field_name_deleted }}" class="field-delete-item" value="">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p class="text-warning">Файлы не загруженны</p>
    @endif
</div>
{!! $errors->first(str_replace_last('[]', '', $field_name), '<p class="help-block" style="color:red;">:message</p>') !!}


{{--
@include('admin.fields.field-images-uploaded',[
     'label' => 'Изображения',
     'field_name' => 'images',
     'entity' => isset($menuItem) ? $menuItem : null,
])
--}}

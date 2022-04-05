<div class="form-group field-more-items">
    <label>{!! $label ?? 'Файлы' !!}</label>
    @php
        $field_name_input = isset($field_name) ? (str_replace_last('[]', '', $field_name) . '[]') : '';
        $field_name_deleted = isset($field_name) ? (str_replace_last('[]', '', $field_name) . '_deleted[]') : '';
        $collection_name = isset($field_name) ? (str_replace_last('[]', '', $field_name)) : '';
    @endphp
    <input type="file" multiple name="{{ $field_name_input }}">
    {{--<p class="help-block">Максимальный размер файлов 1МБ</p>--}}
    @php($collection_name = $collection_name ?? null)
    @if(isset($entity) && $entity->getMedia($collection_name)->count())
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Назваие</th>
                    <th>Размер</th>
                    <th style="width: 40px">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($entity->getMedia($collection_name) as $file)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><a href="{{ $file->getUrl('thumb') }}" title="{{ human_filesize($file->size, 1) }}" target="_blank">{{ str_limit($file->name, 40) }}</a></td>
                    <td>{{ human_filesize($entity->getFirstMedia($collection_name)->size) }}</td>
                    <td>
                        <a href="#" class="filed-remove btn btn-xs btn-danger" data-id="{{ $file->id }}"><i class="fa fa-remove"></i></a>
                        <input type="hidden" name="{{  $field_name_deleted }}" class="field-delete-item" value="">
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
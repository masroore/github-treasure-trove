<div class="box box-warning box-solid field-more-items-sortable">
    <div class="box-header">
        <h3 class="box-title">{!! $label ?? 'Файлы' !!}</h3>
        @php
            $field_name_input = isset($field_name) ? (str_replace_last('[]', '', $field_name) . '[]') : '';
            $field_name_deleted = isset($field_name) ? (str_replace_last('[]', '', $field_name) . '_deleted[]') : '';
            $field_name_weight = isset($field_name) ? (str_replace_last('[]', '', $field_name) . '_weight') : '';
            $collection_name = isset($field_name) ? (str_replace_last('[]', '', $field_name)) : '';
        @endphp
        <input type="file" multiple name="{{ $field_name_input }}">
        {{--<p class="help-block">Максимальный размер файлов {{ $max_size }}</p>--}}
    </div>
    <div class="box-body">
        @if(isset($entity) && $entity->getMedia($collection_name)->count())
        <ul class="todo-list">
            @foreach($entity->getMedia($collection_name) as $file)
            <li>
                <span class="handle">
                    <i class="fa fa-ellipsis-v"></i>
                    <i class="fa fa-ellipsis-v"></i>
                </span>
                <a href="{{ $file->getUrl() }}" target="_blank" title="{{ human_filesize($file->size, 1) }}">
                    <span class="text">{{ str_limit($file->name, 30) }}</span>
                </a>
                <span class="text">{{ $file->mime_type }}</span>

                <div class="tools">
                    <i data-id="{{ $file->id }}" class="fa fa-trash-o filed-remove"></i>
                </div>
                <input type="hidden" name="{{ $field_name_deleted }}" class="field-delete-item" value="">

                <input type="hidden" name="{{ $field_name_weight }}[{{ $file->id }}]" class="field-weight-item" value="{{ $loop->index }}">
            </li>
            @endforeach
        </ul>
        @else
            <div class="box-body">
                <p class="text-warning">Файлы не загруженны</p>
            </div>
        @endif
    </div>  
</div>
{!! $errors->first(str_replace_last('[]', '', $field_name), '<p class="help-block" style="color:red;">:message</p>') !!}
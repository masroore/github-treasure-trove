<div class="box box-warning box-solid field-more-items-sortable">
    <div class="box-header">
        <h3 class="box-title">{!! $label ?? 'Изображения' !!}</h3>
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
            @foreach($entity->getMedia($collection_name) as $image)
            <li>
                <span class="handle">
                    <i class="fa fa-ellipsis-v"></i>
                    <i class="fa fa-ellipsis-v"></i>
                </span>
                <a href="{{ $image->getUrl() }}" target="_blank"><img src="{{ $image->getUrl('thumb') }}" alt=""></a>
                <span class="text">{{ str_limit($image->name, 20) }}</span>

                <div class="tools">
                    <i data-id="{{ $image->id }}" class="fa fa-trash-o filed-remove"></i>
                </div>
                <input type="hidden" name="{{ $field_name_deleted }}" class="field-delete-item" value="">

                <input type="hidden" name="{{ $field_name_weight }}[{{ $image->id }}]" class="field-weight-item" value="{{ $loop->index }}">
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
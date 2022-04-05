{{-- Иерархическое дерево treeview с checkbox-ами --}}
<div
     class="box box-warning box-solid field-tree"
     data-route="{{ $url_tree ?? '#' }}"
     data-field-name="{{ $field_name ?? '' }}"
>
    <div class="box-header">
        <h3 class="box-title">{{ $label ?? 'Категории' }}</h3>
    </div>
    <div class="box-body">
        <div class="field-tree-data"></div>
        <div class="field-tree-inputs"></div>
    </div>
    <div class="overlay">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
</div>
{!! $errors->first(str_replace_last('[]', '', $field_name), '<p class="help-block" style="color:red;">:message</p>') !!}
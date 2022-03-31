@push('page_css')
    <style>

    </style>
@endpush

<ag-doc-block has-blocks="{{ (isset($page) && ! empty($page->blocks->groupBy('type')['pdf'])) ? $page->blocks->groupBy('type')['pdf'] : '' }}"
              resource-id="{{ isset($page) ? $page->id : '' }}"
              image-size="3"
              delete-url="{{ route('page.block.destroy') }}"
></ag-doc-block>

@push('page_js')

@endpush

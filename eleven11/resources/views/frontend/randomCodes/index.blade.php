@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('random_code_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.random-codes.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.randomCode.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.randomCode.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-RandomCode">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.randomCode.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.randomCode.fields.code') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.randomCode.fields.active') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.randomCode.fields.location_code') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.randomCode.fields.company') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($randomCodes as $key => $randomCode)
                                    <tr data-entry-id="{{ $randomCode->id }}">
                                        <td>
                                            {{ $randomCode->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $randomCode->code ?? '' }}
                                        </td>
                                        <td>
                                            {{ $randomCode->active ?? '' }}
                                        </td>
                                        <td>
                                            {{ $randomCode->location_code->location_code ?? '' }}
                                        </td>
                                        <td>
                                            {{ $randomCode->company->company_name ?? '' }}
                                        </td>
                                        <td>
                                            @can('random_code_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.random-codes.show', $randomCode->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('random_code_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.random-codes.edit', $randomCode->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('random_code_delete')
                                                <form action="{{ route('frontend.random-codes.destroy', $randomCode->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('random_code_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.random-codes.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-RandomCode:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
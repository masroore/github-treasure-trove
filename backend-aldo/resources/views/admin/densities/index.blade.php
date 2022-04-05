@extends('layouts.admin')
@section('content')
@can('density_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.densities.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.density.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Density', 'route' => 'admin.densities.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.density.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Density">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.density.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.density.fields.kelurahans') }}
                        </th>
                        <th>
                            {{ trans('cruds.density.fields.area') }}
                        </th>
                        <th>
                            {{ trans('cruds.density.fields.population') }}
                        </th>
                        <th>
                            {{ trans('cruds.density.fields.density') }}
                        </th>
                        <th>
                            {{ trans('cruds.density.fields.year') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($densities as $key => $density)
                        <tr data-entry-id="{{ $density->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $density->id ?? '' }}
                            </td>
                            <td>
                                {{ $density->kelurahans->name ?? '' }}
                            </td>
                            <td>
                                {{ $density->area ?? '' }}
                            </td>
                            <td>
                                {{ $density->population ?? '' }}
                            </td>
                            <td>
                                {{ $density->density ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Density::YEAR_SELECT[$density->year] ?? '' }}
                            </td>
                            <td>
                                @can('density_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.densities.show', $density->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('density_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.densities.edit', $density->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('density_delete')
                                    <form action="{{ route('admin.densities.destroy', $density->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('density_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.densities.massDestroy') }}",
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
  let table = $('.datatable-Density:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection

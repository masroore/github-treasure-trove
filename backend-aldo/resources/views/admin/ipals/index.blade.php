@extends('layouts.admin')
@section('content')
@can('ipal_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.ipals.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.ipal.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Ipal', 'route' => 'admin.ipals.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.ipal.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Ipal">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.ipal.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.ipal.fields.kelurahans') }}
                        </th>
                        <th>
                            {{ trans('cruds.ipal.fields.categories') }}
                        </th>
                        <th>
                            {{ trans('cruds.ipal.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.ipal.fields.address') }}
                        </th>
                        <th>
                            {{ trans('cruds.ipal.fields.lat') }}
                        </th>
                        <th>
                            {{ trans('cruds.ipal.fields.lng') }}
                        </th>
                        <th>
                            {{ trans('cruds.ipal.fields.capacity') }}
                        </th>
                        <th>
                            {{ trans('cruds.ipal.fields.year') }}
                        </th>
                        <th>
                            {{ trans('cruds.ipal.fields.service') }}
                        </th>
                        <th>
                            {{ trans('cruds.ipal.fields.photos') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ipals as $key => $ipal)
                        <tr data-entry-id="{{ $ipal->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $ipal->id ?? '' }}
                            </td>
                            <td>
                                {{ $ipal->kelurahans->name ?? '' }}
                            </td>
                            <td>
                                {{ $ipal->categories->type ?? '' }}
                            </td>
                            <td>
                                {{ $ipal->name ?? '' }}
                            </td>
                            <td>
                                {{ $ipal->address ?? '' }}
                            </td>
                            <td>
                                {{ $ipal->lat ?? '' }}
                            </td>
                            <td>
                                {{ $ipal->lng ?? '' }}
                            </td>
                            <td>
                                {{ $ipal->capacity ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Ipal::YEAR_SELECT[$ipal->year] ?? '' }}
                            </td>
                            <td>
                                @foreach($ipal->services as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach($ipal->photos as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl('thumb') }}">
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                @can('ipal_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.ipals.show', $ipal->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('ipal_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.ipals.edit', $ipal->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('ipal_delete')
                                    <form action="{{ route('admin.ipals.destroy', $ipal->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('ipal_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.ipals.massDestroy') }}",
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
    pageLength: 10,
  });
  let table = $('.datatable-Ipal:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection

@extends('layouts.admin')
@section('content')
@can('shift_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.shifts.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.shift.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.shift.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Shift">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.shift.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.shift.fields.shift_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.shift.fields.start_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.shift.fields.end_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.shift.fields.start_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.shift.fields.end_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.shift.fields.days') }}
                        </th>
                        <th>
                            {{ trans('cruds.shift.fields.frequency') }}
                        </th>
                        <th>
                            {{ trans('cruds.shift.fields.company') }}
                        </th>
                        <th>
                            {{ trans('cruds.shift.fields.active') }}
                        </th>
                        <th>
                            {{ trans('cruds.shift.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.shift.fields.location') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shifts as $key => $shift)
                        <tr data-entry-id="{{ $shift->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $shift->id ?? '' }}
                            </td>
                            <td>
                                {{ $shift->shift_name ?? '' }}
                            </td>
                            <td>
                                {{ $shift->start_date ?? '' }}
                            </td>
                            <td>
                                {{ $shift->end_date ?? '' }}
                            </td>
                            <td>
                                {{ $shift->start_time ?? '' }}
                            </td>
                            <td>
                                {{ $shift->end_time ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $shift->days ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $shift->days ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ App\Models\Shift::FREQUENCY_SELECT[$shift->frequency] ?? '' }}
                            </td>
                            <td>
                                {{ $shift->company->company_name ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $shift->active ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $shift->active ? 'checked' : '' }}>
                            </td>
                            <td>
                                @foreach($shift->users as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach($shift->locations as $key => $item)
                                    <span class="badge badge-info">{{ $item->location_name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('shift_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.shifts.show', $shift->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('shift_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.shifts.edit', $shift->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('shift_delete')
                                    <form action="{{ route('admin.shifts.destroy', $shift->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('shift_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.shifts.massDestroy') }}",
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
  let table = $('.datatable-Shift:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
@extends('layouts.admin')
@section('content')
@can('sanitation_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.sanitations.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.sanitation.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Sanitation', 'route' => 'admin.sanitations.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.sanitation.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Sanitation">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.sanitation.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.sanitation.fields.kecamatan') }}
                        </th>
                        <th>
                            {{ trans('cruds.sanitation.fields.year') }}
                        </th>
                        <th>
                            {{ trans('cruds.sanitation.fields.secure') }}
                        </th>
                        <th>
                            {{ trans('cruds.sanitation.fields.basic') }}
                        </th>
                        <th>
                            {{ trans('cruds.sanitation.fields.poor') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sanitations as $key => $sanitation)
                        <tr data-entry-id="{{ $sanitation->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $sanitation->id ?? '' }}
                            </td>
                            <td>
                                {{ $sanitation->kecamatan->name ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Sanitation::YEAR_SELECT[$sanitation->year] ?? '' }}
                            </td>
                            <td>
                                {{ $sanitation->secure ?? '' }}
                            </td>
                            <td>
                                {{ $sanitation->basic ?? '' }}
                            </td>
                            <td>
                                {{ $sanitation->poor ?? '' }}
                            </td>
                            <td>
                                @can('sanitation_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.sanitations.show', $sanitation->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('sanitation_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.sanitations.edit', $sanitation->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
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
  
  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Sanitation:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection

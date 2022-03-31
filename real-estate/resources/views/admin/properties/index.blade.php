@extends('layouts.admin')
@section('content')
@can('property_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.properties.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.property.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.property.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Property">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.property.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.property_title') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.property_main_photo') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.rooms') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.property_price') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.per') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.google_map_location') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.year_built') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.area') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.property_photos') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.property_video') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.floor_plans') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.tags') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.available') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.feature_property') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.location') }}
                        </th>
                        <th>
                            {{ trans('cruds.property.fields.amenities') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($properties as $key => $property)
                        <tr data-entry-id="{{ $property->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $property->id ?? '' }}
                            </td>
                            <td>
                                {{ $property->property_title ?? '' }}
                            </td>
                            <td>
                                @if($property->property_main_photo)
                                    <a href="{{ $property->property_main_photo->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $property->property_main_photo->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $property->type->name ?? '' }}
                            </td>
                            <td>
                                {{ $property->rooms ?? '' }}
                            </td>
                            <td>
                                {{ $property->property_price ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Property::PER_SELECT[$property->per] ?? '' }}
                            </td>
                            <td>
                                {{ $property->google_map_location ?? '' }}
                            </td>
                            <td>
                                {{ $property->year_built ?? '' }}
                            </td>
                            <td>
                                {{ $property->area ?? '' }}
                            </td>
                            <td>
                                @foreach($property->property_photos as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl('thumb') }}">
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                {{ $property->property_video ?? '' }}
                            </td>
                            <td>
                                @if($property->floor_plans)
                                    <a href="{{ $property->floor_plans->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $property->floor_plans->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @foreach($property->tags as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ App\Models\Property::STATUS_SELECT[$property->status] ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $property->available ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $property->available ? 'checked' : '' }}>
                            </td>
                            <td>
                                <span style="display:none">{{ $property->feature_property ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $property->feature_property ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $property->location ?? '' }}
                            </td>
                            <td>
                                @foreach($property->amenities as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('property_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.properties.show', $property->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('property_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.properties.edit', $property->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('property_delete')
                                    <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('property_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.properties.massDestroy') }}",
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
    order: [[ 1, 'asc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Property:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
@extends('layouts.admin')
@section('content')
@can('propoerty_inquiry_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            {{-- <a class="btn btn-success btn-lg" href="{{ route('admin.propoerty-inquiries.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.propoertyInquiry.title_singular') }}
            </a> --}}
            <a class="btn btn-info btn-lg" href="{{ route('admin.property.send-message') }}">
                Send Message
            </a>
            <a class="btn btn-info btn-lg" href="{{ route('admin.messages.index') }}">
                View Sent Messages
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.propoertyInquiry.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-PropoertyInquiry">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.propoertyInquiry.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.propoertyInquiry.fields.property') }}
                        </th>
                        <th>
                            {{ trans('cruds.propoertyInquiry.fields.full_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.propoertyInquiry.fields.phone_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.propoertyInquiry.fields.email_address') }}
                        </th>
                        <th>
                            {{ trans('cruds.propoertyInquiry.fields.message') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($propoertyInquiries as $key => $propoertyInquiry)
                        <tr data-entry-id="{{ $propoertyInquiry->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $propoertyInquiry->id ?? '' }}
                            </td>
                            <td>
                                {{ $propoertyInquiry->property->property_title ?? '' }}
                            </td>
                            <td>
                                {{ $propoertyInquiry->full_name ?? '' }}
                            </td>
                            <td>
                                {{ $propoertyInquiry->phone_number ?? '' }}
                            </td>
                            <td>
                                {{ $propoertyInquiry->email_address ?? '' }}
                            </td>
                            <td>
                                {{ $propoertyInquiry->message ?? '' }}
                            </td>
                            <td>
                                @can('propoerty_inquiry_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.propoerty-inquiries.show', $propoertyInquiry->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                {{-- @can('propoerty_inquiry_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.propoerty-inquiries.edit', $propoertyInquiry->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan --}}

                                @can('propoerty_inquiry_delete')
                                    <form action="{{ route('admin.propoerty-inquiries.destroy', $propoertyInquiry->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('propoerty_inquiry_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.propoerty-inquiries.massDestroy') }}",
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
    order: [[ 2, 'asc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-PropoertyInquiry:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection

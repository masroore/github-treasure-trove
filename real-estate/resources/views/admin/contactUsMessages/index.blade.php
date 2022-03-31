@extends('layouts.admin')
@section('content')
@can('contact_us_message_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.contact-us-messages.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.contactUsMessage.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.contactUsMessage.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ContactUsMessage">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.contactUsMessage.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.contactUsMessage.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.contactUsMessage.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.contactUsMessage.fields.message') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contactUsMessages as $key => $contactUsMessage)
                        <tr data-entry-id="{{ $contactUsMessage->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $contactUsMessage->id ?? '' }}
                            </td>
                            <td>
                                {{ $contactUsMessage->name ?? '' }}
                            </td>
                            <td>
                                {{ $contactUsMessage->email ?? '' }}
                            </td>
                            <td>
                                {{ $contactUsMessage->message ?? '' }}
                            </td>
                            <td>
                                @can('contact_us_message_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.contact-us-messages.show', $contactUsMessage->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('contact_us_message_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.contact-us-messages.edit', $contactUsMessage->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('contact_us_message_delete')
                                    <form action="{{ route('admin.contact-us-messages.destroy', $contactUsMessage->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('contact_us_message_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.contact-us-messages.massDestroy') }}",
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
  let table = $('.datatable-ContactUsMessage:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
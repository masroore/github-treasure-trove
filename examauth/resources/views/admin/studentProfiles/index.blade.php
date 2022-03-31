@extends('layouts.admin')
@section('content')
@can('student_profile_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.student-profiles.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.studentProfile.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.studentProfile.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-StudentProfile">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.studentProfile.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.studentProfile.fields.student_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.studentProfile.fields.matric_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.studentProfile.fields.gender') }}
                        </th>
                        <th>
                            {{ trans('cruds.studentProfile.fields.faculty') }}
                        </th>
                        <th>
                            {{ trans('cruds.studentProfile.fields.department') }}
                        </th>
                        <th>
                            {{ trans('cruds.studentProfile.fields.level') }}
                        </th>
                        <th>
                            {{ trans('cruds.studentProfile.fields.passport') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($studentProfiles as $key => $studentProfile)
                        <tr data-entry-id="{{ $studentProfile->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $studentProfile->id ?? '' }}
                            </td>
                            <td>
                                {{ $studentProfile->student_name ?? '' }}
                            </td>
                            <td>
                                {{ $studentProfile->matric_number ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\StudentProfile::GENDER_SELECT[$studentProfile->gender] ?? '' }}
                            </td>
                            <td>
                                {{ $studentProfile->faculty->falculty_name ?? '' }}
                            </td>
                            <td>
                                {{ $studentProfile->department->department_name ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\StudentProfile::LEVEL_SELECT[$studentProfile->level] ?? '' }}
                            </td>
                            <td>
                                @if($studentProfile->passport)
                                    <a href="{{ $studentProfile->passport->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $studentProfile->passport->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @can('student_profile_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.student-profiles.show', $studentProfile->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('student_profile_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.student-profiles.edit', $studentProfile->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('student_profile_delete')
                                    <form action="{{ route('admin.student-profiles.destroy', $studentProfile->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('student_profile_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.student-profiles.massDestroy') }}",
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
  let table = $('.datatable-StudentProfile:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
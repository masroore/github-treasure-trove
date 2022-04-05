@extends('backpack::blank')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form action="{{ route('hrDashboard') }}" method="GET">
                    <div class="form-row">

                        <div class="col">
                            <label for="dropdownMenuLink">@lang('Period')</label>
                            <div class="dropdown show">
                                <a class="btn btn-secondary dropdown-toggle" id="dropdownMenuLink" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $selected_period->name }}</a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    @foreach ($periods as $period)
                                        <li><a class="dropdown-item" href="{{ url()->current() }}/?period={{ $period->id }}">{{ $period->name }}</a></li>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <label for="report_start_date">Début : </label>
                            <input class="form-control" type="date" name="report_start_date" value="{{$start}}">
                        </div>

                        <div class="col">
                            <label for="report_end_date">Fin : </label>
                            <input class="form-control" type="date" name="report_end_date" value="{{$end}}">
                        </div>

                        <div class="col align-bottom">
                            <button id="sumbit" style="position: absolute; bottom: 0;" class="btn btn-primary" type="submit">OK</button>
                        </div>

                    </div>
                </form>
            </div>

            <div class="card-body">

                <table class="table table-striped responsive" id="crudTable">
                    <thead>
                        <tr>
                            <th data-orderable="true">@lang('Teacher')</th>
                            <th>@lang('Planned Hours')</th>
                            <th>@lang('Hours on schedule')</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($teachers as $teacher)
                        <tr>
                            <td>{{ $teacher->name }}</td>
                            <td>
                                @if ($teacher->remoteVolume)
                                    <p>@lang('Remote') : {{ number_format($teacher->remoteVolume, 2, '.', ',') }} h</p>
                                @endif

                                @if ($teacher->volume)
                                    <p>@lang('Face-to-face') : {{ number_format($teacher->volume, 2, '.', ',') }} h</p>
                                @endif

                                @if ($teacher->volume && $teacher->remoteVolume)
                                    <p>
                                        <strong>@lang('Total:') {{ number_format($teacher->volume + $teacher->remoteVolume, 2, '.', ',') }} h</strong>
                                    </p>
                                @endif
                            </td>

                            <td>
                                <p>@lang('Face-to-face') : {{ number_format($teacher->plannedHoursInPeriod($start, $end), 2, '.', ',') }} h</p>
                                <p>@lang('Remote') : {{ number_format($teacher->plannedRemoteHoursInPeriod($start, $end), 2, '.', ',') }} h</p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@section('after_styles')
<!-- DATA TABLES -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/fh-3.1.6/datatables.min.css"/>
@endsection

@section('after_scripts')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/fh-3.1.6/datatables.min.js"></script>

<script>
  $(document).ready(() =>
      $('#crudTable').DataTable({
          "pageLength": 50
      }));
</script>
@endsection

@push('before_styles')
    <style>
        .dropdown-menu {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
@endpush

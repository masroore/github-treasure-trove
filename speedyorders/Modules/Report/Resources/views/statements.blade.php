@extends('layouts.main')

@section('content')

    @include('report::sidebar')

    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Agent Statements</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <div class="col-md-12 m-b-sm">
                        <form action="{{ route('admin.reports.statements') }}">
                            <div class="row">

                                <div class="col-md-3">
                                    <select name="agent_id" class="form-control">
                                        <option value="">All Agents</option>
                                        @forelse( $agents as $agent )
                                            <option value="{{ $agent->id }}" {{ request('agent_id') == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="from_date" name="from_date" placeholder="From Date" value="{{ request('from_date') }}" autocomplete="off">
                                </div>

                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="to_date" name="to_date" placeholder="To Date" value="{{ request('to_date') }}" autocomplete="off">
                                </div>

                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-info" name="exportTicket" title="Export">
                                        <i class="fa fa-download"></i> Export
                                    </button>
                                    <a href="{{route('admin.reports.statements')}}" type="submit" class="btn btn-danger" title="Reset">
                                        <i class="fa fa-recycle"></i>
                                    </a>
                                </div>

                                <div class="clearfix"></div>
                                <br>

                                <div class="col-md-12">
                                    <span style="font-weight: 600;">Note: Maximum 3 months allowed. Please generate partial reports of 3 months</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('ext_js')
    <script src="{{asset('/assets/vendor/select2/dist/js/select2.full.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#depart_date').datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                onSelect: function (dateText) {
                    var newDate = new Date(dateText);
                    newDate.setDate(newDate.getDate() + 1);
                }
            });

            $('#from_date').datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                onSelect: function (dateText) {
                    var newDate = new Date(dateText);
                    newDate.setDate(newDate.getDate() + 1);
                    $('#to_date').removeAttr('disabled')
                        .datepicker('option', {minDate: newDate});
                }
            });

            $('#to_date').datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                onSelect: function (dateText) {
                    var newDate = new Date(dateText);
                    newDate.setDate(newDate.getDate() + 1);
                    $('#export_to_date').val(dateText);
                }
            });

            $('.select2-container--default').width('100%');
        });
    </script>
@endsection

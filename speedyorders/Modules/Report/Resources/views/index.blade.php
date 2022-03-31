@extends('layouts.main')

@section('content')

    @include('report::sidebar')

    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Report Management</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <div class="col-md-12 m-b-sm">
                        <form action="{{ route('admin.reports.index') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="api_source" class="form-control">
                                        <option value="">All GDS</option>
                                        <option value="{{ \Helper::API_SOURCE_SABRE }}" {{ request('api_source') == \Helper::API_SOURCE_SABRE ? 'selected' : '' }}>Sabre</option>
                                        <option value="{{ \Helper::API_SOURCE_PLAZMA }}" {{ request('api_source') == \Helper::API_SOURCE_PLAZMA ? 'selected' : '' }}>Plazma</option>
                                        <option value="{{ \Helper::API_SOURCE_AVANTIK }}" {{ request('api_source') == \Helper::API_SOURCE_AVANTIK ? 'selected' : '' }}>Avantik</option>
                                        <option value="{{ \Helper::API_SOURCE_AMADEUS }}" {{ request('api_source') == \Helper::API_SOURCE_AMADEUS ? 'selected' : '' }}>Amadeus</option>
                                    </select>
                                </div>

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

                                <div class="clearfix"></div>
                                <br>

                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="pnr" name="pnr" placeholder="PNR" value="{{ request('pnr') }}" autocomplete="off">
                                </div>

                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Passenger Name" value="{{ request('full_name') }}" autocomplete="off">
                                </div>

                                <div class="col-md-3">
                                    <select name="airline" id="airline" class="form-control">
                                        <option value="">All Airlines</option>
                                        @foreach($airlines as $airline)
                                            <option value="{{$airline->company}}" {{ request('airline') == $airline->company ? 'selected' : '' }}>{{$airline->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="depart_airport" name="depart_airport" placeholder="Departure Airport" value="{{ request('depart_airport') }}" autocomplete="off">
                                </div>

                                <div class="clearfix"></div>
                                <br>

                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="arrival_airport" name="arrival_airport" placeholder="Arrival Airport" value="{{ request('arrival_airport') }}" autocomplete="off">
                                </div>

                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="depart_date" name="depart_date" placeholder="Departure Date" value="{{ request('depart_date') }}" autocomplete="off">
                                </div>

                                <div class="col-md-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value selected>Ticket Status</option>
                                        <option value="issued" {{ request('status') == 'issued' ? 'selected' : '' }}>Issued</option>
                                        <option value="not_issued" {{ request('status') == 'not_issued' ? 'selected' : '' }}>Not-Issued</option>
                                        <option value="void" {{ request('status') == 'void' ? 'selected' : '' }}>Void</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="refund" {{ request('status') == 'refund' ? 'selected' : '' }}>Refund</option>
                                        <option value="partial refund" {{ request('status') == 'partial refund' ? 'selected' : '' }}>Partial Refund</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-info" name="exportTicket" title="Export">
                                        <i class="fa fa-download"></i> Export
                                    </button>
                                    <a href="{{route('admin.reports.index')}}" type="submit" class="btn btn-danger" title="Reset">
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

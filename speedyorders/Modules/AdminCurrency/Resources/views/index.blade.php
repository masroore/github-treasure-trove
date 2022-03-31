@extends('layouts.main')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Currency Management</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12 m-b-lg">
                    <form action="{{ route('admin.currencies.fetch') }}" method="POST">
                        <div class="row">
                            @csrf
                            <div class="col-md-3">
                                <button type="button" id="updateCurrency" class="btn btn-primary btn-block">
                                    <i class="fa fa-download"></i> UPDATE RATES
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <form action="{{ route('admin.currencies.index') }}" method="GET">
                            <div class="form-group col-md-3">
                                <input type="text" name="from" value="{{ request('from') }}" class="form-control"
                                       placeholder="FROM" id="fromdate" required>
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" name="to" value="{{ request('to') }}" class="form-control"
                                       placeholder="TO" id="todate" required>
                            </div>
                            <div class="form-group col-md-3">
                            </div>
                            <div class="form-group col-md-3">
                                <button class="btn btn-success">
                                    <i class="fa fa-filter"></i> FILTER
                                </button>
                                <a href="{{ route('admin.currencies.index') }}" class="btn btn-warning">RESET</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-responsive m-t-md">
                    <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Date</th>
                        <th>Currency</th>
                        <th>Unit</th>
                        <th>Buying/Rs.</th>
                        <th>Selling/Rs.</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($currencies as $currency)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $currency->date }}</td>
                            <td>{{ $currency->base_currency }}</td>
                            <td>{{ $currency->base_value }}</td>
                            <td>{{ $currency->target_buy }}</td>
                            <td>{{ $currency->target_sell }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                No currency rates for today ...
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('ext_js')
    <script>
        $('#updateCurrency').click(function (e) {
            console.log('fuck');
            $(this).attr('disabled', true)
                .html('<i class="fa fa-spinner fa-spin"></i> Please Wait...');

            $(this).closest('form').submit();
        });

        $('#fromdate').datepicker({
            dateFormat: 'yy-mm-dd',
            readonly: true,
            onSelect: function (dateText) {
                var newDate = new Date(dateText);
                $('#todate').removeAttr('disabled')
                    .datepicker('option', {minDate: newDate});
            }
        });

        $('#todate').datepicker({
            dateFormat: 'yy-mm-dd',
            readonly: true,
        });
    </script>
@endsection

@extends('layouts.main')

@section('content')
<div class="hpanel">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4 pull-left text-left">
                <h4>Coupons History List</h4>
            </div>

            <div class="col-md-4 pull-right text-right">
                <form method="GET" action="{{ route('admin.coupons.histories.index') }}" accept-charset="UTF-8" role="search">
                    <div class="input-group"><input type="text" class="form-control" placeholder="Search">
                        <span class="input-group-btn">
                                <button type="button" class="btn btn-primary-fade"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
            </div>

        </div>
            <div class="table-responsive">
            <table id="productTable" class="table table-bordered table-striped speedy-table">
            <thead>
                <tr>
                    <th>Coupon Code</th>
                    <th>Order Invoice No</th>
                    <th>Customer Email</th>
                    <th>Order Amount</th>
                </tr>
                </thead>
                <tbody>
                @forelse($couponsHistoryDetails as $couponHistory)
                <tr>
                    <td>{{ $couponHistory->coupon->code }} </td>
                    <td>{{ $couponHistory->order->invoice_number }} </td>
                    <td>{{ $couponHistory->customer->email }} </td>
                    <td>{{ $couponHistory->order_amount }} </td>
                </tr>
                @empty
                <tfoot>
                    <tr>
                        <td class="text-center" colspan="10">
                            <span>No data available in the table...</span>
                        </td>
                    </tr>
                </tfoot>
                @endforelse
            </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('ext_js')
    <script>
    </script>
@endsection

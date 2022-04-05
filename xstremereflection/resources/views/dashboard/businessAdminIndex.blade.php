
    <div class="col-xl-4">
        <div class="card widget">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2">
                        <span class="text-warning"><i class="fad fa-file-invoice fa-3x"></i></span>
                    </div>
                    <div class="col-xl-10">
                        <div class="text-muted display-4">
                            ${{$estimates->sum('total')}}
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <h2 class="text-right">Estimate Totals</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card widget">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2">
                       <span class="text-warning"><i class="fad fa-car-wash fa-3x"></i></span>
                    </div>
                    <div class="col-xl-10">
                        <div class="text-muted display-4">
                            ${{$workorders->where('status', '!=', 9)->sum('totalCharge')}}
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <h2 class="text-right">Work Orders Totals</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card widget">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3">
                        <span class="text-success"><i class="fad fa-money-check-edit-alt fa-3x"></i></span>
                    </div>
                    <div class="col-xl-9">
                        <div class="text-muted display-4">
                            ${{$invoiceYTD->sum('totalPaid')}}
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <h2>Income YTD</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="row">
    <div class="col-xl-12">
        <div class="table-responsive">
            <table class="table table">
                <thead>

                </thead>
                <tbody>
                <tr>
                    <th>Total Invoice</th>
                    <td>{{$invoice->total}}</td>
                </tr>
                <tr>
                    <th>Total Paid to Date</th>
                    <td>{{$invoice->totalPaid ?? '$0.00'}}</td>
                </tr>
                <tr>
                    <th>Total Balance</th>
                    <td>{{number_format($invoice->total - $invoice->totalPaid, 2)}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <form action="/invoice/payment/{{$invoice->id}}" method="post">
        @csrf
        <div class="form-group mb-2">
            <label>Payment Amount</label>
            <input type="decimal" class="form-control" step="0.01" name="pmtAmount" />
        </div>


        <button type="submit" class="btn btn-success btn-block" > Submit Payment </button>
    </form>
</div>


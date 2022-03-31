@extends('frontend.layouts.app')
@section('content')
<!-- Title -->
<div class="text-center bg-cover py-5" style="background-color: #00a651;">
    <h1 class="h3 font-weight-bold text-white">Service Fee</h1>
</div>

<section class="container py-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-7">
            <!-- <div class="card border-danger rounded-xl overflow-hidden mb-4">
                <div class="card-header bg-danger">
                    <h2 class="h6 font-weight-bold text-white mb-0">Select Payment Method</h2>
                </div>
                <div class="card-body text-center">
                    <a href="#" class="btn btn-primary mr-2 mb-2">Credit Card</a>
                    <a href="#" class="btn btn-warning mr-2 mb-2">Cash Payment</a>
                    <a href="{{ route('payments.deposit') }}" class="btn btn-info mr-2 mb-2">Paypal</a>
                </div>
            </div> -->
            <form action="{{ route('payment')}} " method="get">
                @csrf
                <div class="card border-success rounded-xl overflow-hidden mb-4">
                    <div class="card-header bg-success py-3">
                        <h2 class="h6 font-weight-bold text-white mb-0">Paypal Payment</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Product Name:</span>
                            <span>Project</span>
                        </div>
                        <div class="row mb-3">
                            <label for="amount" class="col-md-4">Amount of Payment:</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" id="paypal_deposit_amt" name="paypal_deposit_amt" placeholder="1000" min="0" onkeyup="PaypalFeeFun()">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Fees:</span>
                            <span id="Paypal_fee">00.00</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-4">
                            <span>Final amount:</span>
                            <span id="Paypal_final_amt">00.00</span>
                        </div>

                        <div class="text-center">
                            <input type="submit" value="Payment" class="btn wt-btn">
                            {{-- <button class="btn btn-info">
                                <i class="fa fa-paper-plane-o mr-1"></i>
                                Payment
                            </button> --}}
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- <div class="col-md-5">
            <div class="card border-secondary rounded-xl overflow-hidden mb-4">
                <div class="card-header bg-secondary text-center">
                    <h2 class="h6 font-weight-bold text-white mb-0">Bluefreelancer Paid service guide</h2>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <button class="btn btn-sm btn-wide btn-info">Chat</button>
                        </div>

                        <div class="col-md-6">
                            <h6 class="font-size-sm font-weight-bold mb-1">Unlimited chat for 30 days!</h6>
                            <p class="font-size-ms">Free 1: 1 video chat on purchase</p>
                        </div>

                        <div class="col-md-2">
                            <p class="font-size-sm">$100</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <button class="btn btn-sm btn-wide btn-primary">Private</button>
                        </div>

                        <div class="col-md-6">
                            <h6 class="font-size-sm font-weight-bold mb-1">Each freelancer can not see the support
                                contents.</h6>
                        </div>

                        <div class="col-md-2">
                            <p class="font-size-sm">$150</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <button class="btn btn-sm btn-wide btn-danger">Urgent</button>
                        </div>

                        <div class="col-md-6">
                            <h6 class="font-size-sm font-weight-bold mb-1">Fast response and urgent service.</h6>
                        </div>

                        <div class="col-md-2">
                            <p class="font-size-sm">$180</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</section>
@endsection
@section('script')
<script>
    function PaypalFeeFun() {
        var amt = $('#paypal_deposit_amt').val();
        var fee = (Number(amt) * 0.0359) / (1 + 0.0359);
        var net = Number(amt) / (1 + 0.0359);
        $('#Paypal_fee').html(fee.toFixed(2));
        $('#Paypal_final_amt').html(net.toFixed(2));
    }
</script>
@endsection
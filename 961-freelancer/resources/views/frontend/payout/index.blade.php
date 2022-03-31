@extends('frontend.layouts.app')
@section('content')
<!-- Title -->
<div class="text-center bg-cover py-5" style="background-color: #00a651;">
    <h1 class="h3 font-weight-bold text-white">Payment Withdraw</h1>
</div>

<section class="container py-5">
    <div class="row">
        <div class="col-md-7 mx-auto">
            <form action="{{ route('payout')}} " method="get">
                @csrf
                <div class="card border-success rounded-xl overflow-hidden mb-4">
                    <div class="card-header bg-success py-3">
                        <h2 class="h6 font-weight-bold text-white mb-0">Paypal Payment Withdraw</h2>
                    </div>
                    <div class="card-body">
                        @if (session()->has('withdrawMessage'))
                        <div class="d-flex alert alert-success text-center">{{ session()->pull('withdrawMessage') }}</div>
                        @endif
                        <div class="d-flex justify-content-between mb-3">
                            <span>Current Balance:</span>
                            <span>${{ App\Models\Wallet::where('user_id', auth()->id())->first() ?
                                App\Models\Wallet::where('user_id', auth()->id())->first()->amt : '0.0' }}</span>
                        </div>
                        <div class="row mb-3">
                            <label for="amount" class="col-md-4">Withdrawal Amount:</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" id="paypal_withdraw_amt"
                                    name="paypal_withdraw_amt" min="0" placeholder="30">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4">Paypal Email:</label>
                            <div class="col-md-8">
                                <input type="email" class="form-control" id="paypal_email" name="paypal_email" readonly
                                    value="{{ auth()->user()->paypal_email ? auth()->user()->paypal_email : 'Your Paypal Account is not verify Kindly verify it!' }}">
                            </div>
                        </div>

                        <div class="text-center">
                            <input type="submit" value="Withdraw" class="btn wt-btn">
                            {{-- <button class="btn btn-info">
                                <i class="fa fa-paper-plane-o mr-1"></i>
                                Payment
                            </button> --}}
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <span><b>Note:</b> Minimum Withdrawal is $30.</span>
        </div>
    </div>
</section>
@endsection
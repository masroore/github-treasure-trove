<!DOCTYPE html>
<html>
<head>

    <title>Report Print</title>

    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="stylesheet" href="{{asset('backEnd/')}}/css/rtl/bootstrap.min.css"/>

    <style>
        .invoice_heading {
            border-bottom: 1px solid black;
            padding: 20px;
            text-transform: capitalize;
        }
        body{
            font-family: "Poppins", sans-serif;
        }
        .invoice_logo {
            width: 50%;
            float: left;
            text-align: left;
        }

        .invoice_no {
            text-align: right;
            color: #415094;
        }

        .invoice_info {
            padding: 20px;
            width: 100%;
            text-transform: capitalize;
            min-height: 100px;
        }
        table {
            text-align: left;
            font-family: "Poppins", sans-serif;
        }

        td, th {
            color: #828bb2;
            font-size: 13px;
            font-weight: 400;
            font-family: "Poppins", sans-serif;
        }

        th {
            font-weight: 600;
            font-family: "Poppins", sans-serif;
        }
        .margin_120{
            margin-top: 120px;
            font-size: 12px;
        }.margin_12{
            margin-bottom: 120px;
            font-size: 12px;
        }
        .invoice_footer{
            position: absolute;
            left: 0;
            bottom: 180px;
            width: 100%;
        }

        .invoice_info_footer {
            padding: 0px;
            width: 100%;
            left: 0;
            text-transform: capitalize;
            position: inherit;
        }

        p {
            font-size: 10px;
            color: #454545;
            line-height: 16px;
        }
        .extra_div {
            height:100;
        }
        .a4_width {
           max-width: 210mm;
           margin: auto;
        }
    </style>
</head>
<body>
@php
    $setting = app('general_setting');
@endphp
<div class="container-fluid ">
    <div class="invoice_heading">
        <div class="invoice_logo">
            <img src="{{asset($setting->logo)}}" width="100px" alt="">
        </div>
        <div class="invoice_no">
            <h4>{{__('report.Print')}} : {{date('m-d-Y')}}</h4>
        </div>
    </div>
    <div class="invoice_info">
        <div class="invoice_logo">
            <table class="table-borderless">
                <tr>
                    <td><b>{{__('sale.Company')}}</b></td>
                    <td><b>:</b></td>
                    <td>{{$setting->company_name}}</td>
                </tr>
                <tr>
                    <td><b>{{__('common.Phone')}}</b></td>
                    <td><b>:</b></td>
                    <td>{{$setting->phone}}</td>
                </tr>
                <tr>
                    <td><b>{{__('common.Email')}}</b></td>
                    <td><b>:</b></td>
                    <td>{{$setting->email}}</td>
                </tr>
                <tr>
                    <td><b>{{__('sale.Website')}}</b></td>
                    <td><b>:</b></td>
                    <td><a href="#">infix.pos.com</a></td>
                </tr>
                <tr>
                    <td><b>{{__('common.Account Name')}}</b></td>
                    <td><b>:</b></td>
                    <td>{{ $beforedateAccount->name }}</td>
                </tr>
                <tr>
                    <td><b>{{__('common.Date Range')}}</b></td>
                    <td><b>:</b></td>
                    <td>{{ date(app('general_setting')->dateFormat->format, strtotime($dateFrom)) }} to {{ date(app('general_setting')->dateFormat->format, strtotime($dateTo)) }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="invoice_info">
        <table class="table table-bordered billing_info">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">{{ __('account.Date') }}</th>
                        <th scope="col">{{ __('account.Reference No.') }}</th>
                        <th scope="col">{{ __('account.Description') }}</th>
                        <th scope="col">{{ __('account.Debit') }}</th>
                        <th scope="col">{{ __('account.Credit') }}</th>
                        <th scope="col" class="text-right">{{ __('account.Balance') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $currentBalance = 0 + $balance + $opening_balance;
                    @endphp
                    <tr>
                        <td>{{ __('account.Openning Balance') }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">{{ single_price($currentBalance) }}</td>
                    </tr>
                    @foreach ($transactions->sort() as $key => $payment)
                        @if ($payment->type != "Dr")
                            @php
                                $currentBalance -= $payment->amount;
                            @endphp
                        @else
                            @php
                                $currentBalance += $payment->amount;
                            @endphp
                        @endif
                        <tr>
                            <td>{{ date(app('general_setting')->dateFormat->format, strtotime(@$payment->voucherable->date)) }}</td>
                            <td>
                              <a onclick="voucher_detail({{ $payment->voucherable->id }})">{{ (@$payment->voucherable->referable->invoice_no) ? @$payment->voucherable->referable->invoice_no : @$payment->voucherable->tx_id }}</a>
                            </td>
                            <td>{{ @$payment->voucherable->narration }}</td>
                            <td>
                                @if ($payment->type == "Dr")
                                    {{ single_price($payment->amount) }}
                                    <input type="hidden" name="debit[]" value="{{ $payment->amount }}">
                                @endif
                            </td>
                            <td>
                                @if ($payment->type == "Cr")
                                    {{ single_price($payment->amount) }}
                                    <input type="hidden" name="credit[]" value="{{ $payment->amount }}">
                                @endif
                            </td>
                            <td class="text-right">{{ single_price($currentBalance) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total</td>
                        <td class="text-right">{{ single_price($currentBalance) }}</td>
                    </tr>
                </tbody>
            </table>

        </table>
    </div>
</div>

</body>
</html>

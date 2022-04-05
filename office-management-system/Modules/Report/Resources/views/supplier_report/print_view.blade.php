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
            margin-bottom:20px;
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
                    <td>{{ $chartAccount->name }}</td>
                </tr>
                <tr>
                    <td><b>{{__('report.Print')}}</b></td>
                    <td><b>:</b></td>
                    <td>{{date('Y-m-d H:i:s')}}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="invoice_info">
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
                    
                    $currentBalance = 0 + ($supplier->opening_balance ? $supplier->opening_balance : 0);
                @endphp
                <tr>
                    <td>{{ __('account.Openning Balance') }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">{{ single_price($currentBalance) }}</td>
                </tr>
                @foreach ($chartAccount->transactions as $key => $payment)
                    @if ($payment->type == "Cr")
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
                        <td>{{ (@$payment->voucherable->referable->ref_no) ?? @$payment->voucherable->tx_id }}</td>
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
                    <td>{{__('report.Current Balance')}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">{{ single_price($currentBalance) }}</td>
                </tr>
            </tbody>
        </table>

    </div>
</div>

</body>
</html>

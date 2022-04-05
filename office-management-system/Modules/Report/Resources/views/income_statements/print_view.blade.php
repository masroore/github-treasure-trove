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
                    <td><b>{{ __('report.Accounting Time Period') }}</b></td>
                    <td><b>:</b></td>
                    <td>{{ $timePeriod->start_date }} - {{ ($timePeriod->end_date) ? $timePeriod->end_date : "Present" }}</td>
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
                <th scope="col">{{__('account.Account Name')}}</th>
                <th scope="col">{{__('report.Calculation')}}</th>
                <th scope="col">{{__('report.Balance')}}</th>
            </tr>
            </thead>
            @php
                $total_expense = 0;
                $total_other_income = 0;
                $cost_of_goods_sold = $expenseAccounts->where('code', '03-19')->first();
                $income_account_list = $incomeAccounts->whereNotIn('code', ['04-24', '04-15']);
                $expense_account_list = $expenseAccounts->whereNotIn('code', ['03-23', '03-19']);
                $total_profit = $saleTransactionBalance - $costFoGoodsTransactionBalance;
            @endphp
            <tbody>
                <tr>
                    <td>{{__('report.Total Sale')}}</td>
                    <td></td>
                    <td>{{ single_price($saleTransactionBalance) }}</td>
                </tr>
                <tr>
                    <td><span class="ml-5"></span>(-) {{__('report.Total Cost Of Goods Sold')}}</td>
                    <td></td>
                    <td>{{single_price($costFoGoodsTransactionBalance)}}</td>
                </tr>
                <tr>
                    <td>{{__('report.Total Profit (Total Sale - Total Cost Of Goods Sold)')}}</td>
                    <td></td>
                    <td>{{ single_price($total_profit) }}</td>
                </tr>
                <tr>
                    <th>{{__('report.Expense')}}</th>
                    <th></th>
                    <th></th>
                </tr>
                @foreach ($expense_account_list as $key => $expenseAccount)
                    @php
                        $total_expense += $expenseAccount->BalanceAmount;
                    @endphp
                    <tr>
                        <td><span class="ml-5"></span>{{ $expenseAccount->name }}</td>
                        <td>{{ single_price($expenseAccount->BalanceAmount) }}</td>
                        <td></td>
                    </tr>
                @endforeach
                <tr>
                    <td>(-) {{__('report.Total Expense')}}</td>
                    <td></td>
                    <td>{{single_price($total_expense)}}</td>
                </tr>
                <tr>
                    <th>{{__('report.Income')}}</th>
                    <th></th>
                    <th></th>
                </tr>
                @foreach ($income_account_list as $key => $incomeAccount)
                    @php
                        $total_other_income += $incomeAccount->BalanceAmount;
                    @endphp
                    <tr>
                        <td><span class="ml-5"></span>{{ $incomeAccount->name }}</td>
                        <td>{{ single_price($incomeAccount->BalanceAmount) }}</td>
                        <td></td>
                    </tr>
                @endforeach
                <tr>
                    <td>{{__('report.Total Income')}}</td>
                    <td></td>
                    <td>{{ single_price($total_other_income) }}</td>
                </tr>
                <tr>
                    <td>{{__('report.Net Profit or Loss before Tax  (Total Profit - Total Expense + Total Other Income)')}}</td>
                    <td></td>
                    <td>{{ single_price(round($total_profit - $total_expense + $total_other_income)) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

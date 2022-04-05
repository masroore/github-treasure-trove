<!DOCTYPE html>
<html>
<head>

    <title>Invoice</title>

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

        .invoice_logo {
            width: 50%;
            float: left;
            text-align: left;
        }

        .invoice_logo_right {
            width: 50%;
            float: right;
            text-align: right;
        }

        .invoice_no {
            text-align: right;
            color: #415094;
        }

        .invoice_info {
            padding: 20px;
            text-transform: capitalize;
        }

        .billing_info {
            margin-top: 115px;
        }

        table {
            text-align: left;
        }

        td, th {
            color: #828bb2;
            font-size: 13px;
            font-weight: 400;
            font-family: "Poppins", sans-serif;
        }

        th {
            font-weight: 600;
        }

        li {
            list-style-type: none;
            text-align: left;
        }

        .sale_note {
            width: 45%;
            float: left;
            text-align: left;
        }

        .notes {
            color: #415094;
            font-size: 18px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .note_details {
            font-size: 14px;
            font-weight: 600;
            color: #828BB2 !important;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="invoice_heading">
        <div class="invoice_logo">
            <img src="{{asset(app('general_setting')->logo)}}" width="100px" alt="">
        </div>
        <div class="invoice_no">
            <h4>{{ __('payroll.Payslip Details') }}</h4>
        </div>
    </div>
    <div class="invoice_info">
        <div class="invoice_logo">
            <table class="table-borderless">
                <tr>
                    <td><b>{{__('sale.Company')}}</b></td>
                    <td><b>:</b></td>
                    <td>{{ app('general_setting')->company_name }}</td>
                </tr>
                <tr>
                    <td><b>{{__('common.Phone')}}</b></td>
                    <td><b>:</b></td>
                    <td><a href="tel:{{app('general_setting')->phone}}">{{app('general_setting')->phone}}</a></td>
                </tr>
                <tr>
                    <td><b>{{__('common.Email')}}</b></td>
                    <td><b>:</b></td>
                    <td><a href="mailto:{{app('general_setting')->email}}">{{app('general_setting')->email}}</a></td>
                </tr>
                <tr>
                    <td><b>{{__('payroll.Address')}}</b></td>
                    <td><b>:</b></td>
                    <td><a href="">{{app('general_setting')->address}}</a></td>
                </tr>
            </table>
        </div>
        <div class="invoice_logo">
            <table class="table-borderless">
                <tr>
                    <td><b>{{__('payroll.Prepared By')}}</b></td>
                    <td><b>:</b></td>
                    <td>{{ userName($payrollDetails->created_by) }}</td>
                </tr>
                <tr>
                    <td><b>{{__('payroll.Approved By')}}</b></td>
                    <td><b>:</b></td>
                    <td><a href="tel:{{app('general_setting')->phone}}">{{app('general_setting')->phone}}</a></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="invoice_info">
        <table class="table table-bordered billing_info">
            <tr>
                <th scope="col">{{ __('common.Staff ID') }}</th>
                <td class="p-2">{{$payrollDetails->staff->employee_id}}</td>
            </tr>
            <tr>
                <th scope="col">{{ __('common.Name') }}</th>
                <td class="p-2">{{$payrollDetails->staff->user->name}}</td>
            </tr>
            <tr>
                <th scope="col">{{ __('department.Department') }}</th>
                <td class="p-2">{{$payrollDetails->staff->department->name}}</td>
            </tr>
            <tr>
                <th scope="col">{{ __('payroll.Payment Method') }}</th>
                <td class="p-2">{{strtoupper($payrollDetails->payment_mode)}}</td>
            </tr>
            <tr>
                <th scope="col">{{ __('payroll.Basic Salary') }}</th>
                <td class="p-2">{{single_price($payrollDetails->basic_salary)}}</td>
            </tr>
            <tr>
                <th scope="col">{{ __('payroll.Total Earning') }}</th>
                <td class="p-2">{{single_price($payrollDetails->total_earning)}}</td>
            </tr>
            <tr>
                <th scope="col">{{ __('payroll.Total Deduction') }}</th>
                <td class="p-2">{{single_price($payrollDetails->total_deduction)}}</td>
            </tr>
            <tr>
                <th scope="col">{{ __('payroll.Net Salary') }}</th>
                <td class="p-2">{{single_price($payrollDetails->net_salary)}}</td>
            </tr>
            <tr>
                <th scope="col">{{ __('payroll.Gross Salary') }}</th>
                <td class="p-2">{{single_price($payrollDetails->gross_salary)}}</td>
            </tr>
        </table>
    </div>
</div>


</body>
</html>

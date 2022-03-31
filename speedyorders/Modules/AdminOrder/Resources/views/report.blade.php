<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <title>Invoice</title>
    {{-- <link rel="stylesheet" href="{{asset('vendor/bootstrap/dist/css/bootstrap.css')}}" /> --}}

      {{-- <base href="https://speedyorders.com/admin/" /> --}}
      {{-- <link href="view/javascript/bootstrap/css/bootstrap.css" rel="stylesheet" media="all" /> --}}
      {{-- <script type="ee0ac57748b28c9079bdb849-text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
      <script type="ee0ac57748b28c9079bdb849-text/javascript" src="view/javascript/bootstrap/js/bootstrap.min.js"></script>
      <link href="view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
      <link type="text/css" href="view/stylesheet/stylesheet.css" rel="stylesheet" media="all" /> --}}
    <style>
              .container {
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
  }
  @media (min-width: 768px) {
    .container {
      width: 750px;
    }
  }
  @media (min-width: 992px) {
    .container {
      width: 970px;
    }
  }
  @media (min-width: 1200px) {
    .container {
      width: 1170px;
    }
  }
  .container-fluid {
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
  }

  .container > .navbar-header,
  .container-fluid > .navbar-header,
  .container > .navbar-collapse,
  .container-fluid > .navbar-collapse {
    margin-right: -15px;
    margin-left: -15px;
  }
  @media (min-width: 768px) {
    .container > .navbar-header,
    .container-fluid > .navbar-header,
    .container > .navbar-collapse,
    .container-fluid > .navbar-collapse {
      margin-right: 0;
      margin-left: 0;
    }
  }

  @media (min-width: 768px) {
    .navbar > .container .navbar-brand,
    .navbar > .container-fluid .navbar-brand {
      margin-left: -15px;
    }
  }

  .container .jumbotron,
  .container-fluid .jumbotron {
    padding-right: 15px;
    padding-left: 15px;
    border-radius: 6px;
  }
  .jumbotron .container {
    max-width: 100%;
  }
  @media screen and (min-width: 768px) {
    .jumbotron {
      padding-top: 48px;
      padding-bottom: 48px;
    }
    .container .jumbotron,
    .container-fluid .jumbotron {
      padding-right: 60px;
      padding-left: 60px;
    }
    .jumbotron h1,
    .jumbotron .h1 {
      font-size: 63px;
    }
  }

  table {
    border-spacing: 0;
    border-collapse: collapse;
  }
  td,
  th {
    padding: 0;
  }

  thead {
      display: table-header-group;
    }
    .table {
      border-collapse: collapse !important;
    }
    .table td,
    .table th {
      background-color: #fff !important;
    }
    .table-bordered th,
    .table-bordered td {
      border: 1px solid #ddd !important;
    }

    .table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
  }
  .table > thead > tr > th,
  .table > tbody > tr > th,
  .table > tfoot > tr > th,
  .table > thead > tr > td,
  .table > tbody > tr > td,
  .table > tfoot > tr > td {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
  }
  .table > thead > tr > th {
    vertical-align: bottom;
    border-bottom: 2px solid #ddd;
  }
  .table > caption + thead > tr:first-child > th,
  .table > colgroup + thead > tr:first-child > th,
  .table > thead:first-child > tr:first-child > th,
  .table > caption + thead > tr:first-child > td,
  .table > colgroup + thead > tr:first-child > td,
  .table > thead:first-child > tr:first-child > td {
    border-top: 0;
  }
  .table > tbody + tbody {
    border-top: 2px solid #ddd;
  }
  .table .table {
    background-color: #fff;
  }
  .table-condensed > thead > tr > th,
  .table-condensed > tbody > tr > th,
  .table-condensed > tfoot > tr > th,
  .table-condensed > thead > tr > td,
  .table-condensed > tbody > tr > td,
  .table-condensed > tfoot > tr > td {
    padding: 5px;
  }
  .table-bordered {
    border: 1px solid #ddd;
  }
  .table-bordered > thead > tr > th,
  .table-bordered > tbody > tr > th,
  .table-bordered > tfoot > tr > th,
  .table-bordered > thead > tr > td,
  .table-bordered > tbody > tr > td,
  .table-bordered > tfoot > tr > td {
    border: 1px solid #ddd;
  }
  .table-bordered > thead > tr > th,
  .table-bordered > thead > tr > td {
    border-bottom-width: 2px;
  }
  .table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #f9f9f9;
  }
  .table-hover > tbody > tr:hover {
    background-color: #f5f5f5;
  }
  table col[class*="col-"] {
    position: static;
    display: table-column;
    float: none;
  }
  table td[class*="col-"],
  table th[class*="col-"] {
    position: static;
    display: table-cell;
    float: none;
  }
  .table > thead > tr > td.active,
  .table > tbody > tr > td.active,
  .table > tfoot > tr > td.active,
  .table > thead > tr > th.active,
  .table > tbody > tr > th.active,
  .table > tfoot > tr > th.active,
  .table > thead > tr.active > td,
  .table > tbody > tr.active > td,
  .table > tfoot > tr.active > td,
  .table > thead > tr.active > th,
  .table > tbody > tr.active > th,
  .table > tfoot > tr.active > th {
    background-color: #f5f5f5;
  }
  .table-hover > tbody > tr > td.active:hover,
  .table-hover > tbody > tr > th.active:hover,
  .table-hover > tbody > tr.active:hover > td,
  .table-hover > tbody > tr:hover > .active,
  .table-hover > tbody > tr.active:hover > th {
    background-color: #e8e8e8;
  }
  .table > thead > tr > td.success,
  .table > tbody > tr > td.success,
  .table > tfoot > tr > td.success,
  .table > thead > tr > th.success,
  .table > tbody > tr > th.success,
  .table > tfoot > tr > th.success,
  .table > thead > tr.success > td,
  .table > tbody > tr.success > td,
  .table > tfoot > tr.success > td,
  .table > thead > tr.success > th,
  .table > tbody > tr.success > th,
  .table > tfoot > tr.success > th {
    background-color: #dff0d8;
  }
  .table-hover > tbody > tr > td.success:hover,
  .table-hover > tbody > tr > th.success:hover,
  .table-hover > tbody > tr.success:hover > td,
  .table-hover > tbody > tr:hover > .success,
  .table-hover > tbody > tr.success:hover > th {
    background-color: #d0e9c6;
  }
  .table > thead > tr > td.info,
  .table > tbody > tr > td.info,
  .table > tfoot > tr > td.info,
  .table > thead > tr > th.info,
  .table > tbody > tr > th.info,
  .table > tfoot > tr > th.info,
  .table > thead > tr.info > td,
  .table > tbody > tr.info > td,
  .table > tfoot > tr.info > td,
  .table > thead > tr.info > th,
  .table > tbody > tr.info > th,
  .table > tfoot > tr.info > th {
    background-color: #d9edf7;
  }
  .table-hover > tbody > tr > td.info:hover,
  .table-hover > tbody > tr > th.info:hover,
  .table-hover > tbody > tr.info:hover > td,
  .table-hover > tbody > tr:hover > .info,
  .table-hover > tbody > tr.info:hover > th {
    background-color: #c4e3f3;
  }
  .table > thead > tr > td.warning,
  .table > tbody > tr > td.warning,
  .table > tfoot > tr > td.warning,
  .table > thead > tr > th.warning,
  .table > tbody > tr > th.warning,
  .table > tfoot > tr > th.warning,
  .table > thead > tr.warning > td,
  .table > tbody > tr.warning > td,
  .table > tfoot > tr.warning > td,
  .table > thead > tr.warning > th,
  .table > tbody > tr.warning > th,
  .table > tfoot > tr.warning > th {
    background-color: #fcf8e3;
  }
  .table-hover > tbody > tr > td.warning:hover,
  .table-hover > tbody > tr > th.warning:hover,
  .table-hover > tbody > tr.warning:hover > td,
  .table-hover > tbody > tr:hover > .warning,
  .table-hover > tbody > tr.warning:hover > th {
    background-color: #faf2cc;
  }
  .table > thead > tr > td.danger,
  .table > tbody > tr > td.danger,
  .table > tfoot > tr > td.danger,
  .table > thead > tr > th.danger,
  .table > tbody > tr > th.danger,
  .table > tfoot > tr > th.danger,
  .table > thead > tr.danger > td,
  .table > tbody > tr.danger > td,
  .table > tfoot > tr.danger > td,
  .table > thead > tr.danger > th,
  .table > tbody > tr.danger > th,
  .table > tfoot > tr.danger > th {
    background-color: #f2dede;
  }
  .table-hover > tbody > tr > td.danger:hover,
  .table-hover > tbody > tr > th.danger:hover,
  .table-hover > tbody > tr.danger:hover > td,
  .table-hover > tbody > tr:hover > .danger,
  .table-hover > tbody > tr.danger:hover > th {
    background-color: #ebcccc;
  }
  .table-responsive {
    min-height: .01%;
    overflow-x: auto;
  }
  @media screen and (max-width: 767px) {
    .table-responsive {
      width: 100%;
      margin-bottom: 15px;
      overflow-y: hidden;
      -ms-overflow-style: -ms-autohiding-scrollbar;
      border: 1px solid #ddd;
    }
    .table-responsive > .table {
      margin-bottom: 0;
    }
    .table-responsive > .table > thead > tr > th,
    .table-responsive > .table > tbody > tr > th,
    .table-responsive > .table > tfoot > tr > th,
    .table-responsive > .table > thead > tr > td,
    .table-responsive > .table > tbody > tr > td,
    .table-responsive > .table > tfoot > tr > td {
      white-space: nowrap;
    }
    .table-responsive > .table-bordered {
      border: 0;
    }
    .table-responsive > .table-bordered > thead > tr > th:first-child,
    .table-responsive > .table-bordered > tbody > tr > th:first-child,
    .table-responsive > .table-bordered > tfoot > tr > th:first-child,
    .table-responsive > .table-bordered > thead > tr > td:first-child,
    .table-responsive > .table-bordered > tbody > tr > td:first-child,
    .table-responsive > .table-bordered > tfoot > tr > td:first-child {
      border-left: 0;
    }
    .table-responsive > .table-bordered > thead > tr > th:last-child,
    .table-responsive > .table-bordered > tbody > tr > th:last-child,
    .table-responsive > .table-bordered > tfoot > tr > th:last-child,
    .table-responsive > .table-bordered > thead > tr > td:last-child,
    .table-responsive > .table-bordered > tbody > tr > td:last-child,
    .table-responsive > .table-bordered > tfoot > tr > td:last-child {
      border-right: 0;
    }
    .table-responsive > .table-bordered > tbody > tr:last-child > th,
    .table-responsive > .table-bordered > tfoot > tr:last-child > th,
    .table-responsive > .table-bordered > tbody > tr:last-child > td,
    .table-responsive > .table-bordered > tfoot > tr:last-child > td {
      border-bottom: 0;
    }
  }
  .text-right {
  text-align: right;
}
  h1{
      font-family: cursive !important;
  }

  small,
.small {
  font-size: 85%;
}


    </style>
   </head>
   <body>
      <div class="container report">
         <div style="page-break-after: always;">
            <h1>Invoice No. : {{ $order->invoice_prefix.$order->invoice_number }}</h1>
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <td colspan="2">Order Details</td>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td style="width: 50%;">
                        <address>
                           <strong>{{ Option::get('company_name') }}</strong><br />
                           {{ Option::get('company_address') }} <br />
                        </address>
                        <b>Telephone</b> {{ Option::get('company_phone') }}<br />
                        <b>E-Mail</b> {{ Option::get('company_phone') }}</a><br />
                        <b>Web Site:</b> <a href="{{ Option::get('company_site') }}">{{ Option::get('company_site') }}</a>
                     </td>
                     <td style="width: 50%;"><b>Date Added</b> {{ $order->created_at }}<br />
                        <b>Order ID:</b>  {{ $order->invoice_prefix.$order->invoice_number }}<br />
                        <b>Payment Method</b> {{ $order->payment_method }}<br />
                        <b>Shipping Method</b> {{ $order->shipping_method }}<br />
                     </td>
                  </tr>
               </tbody>
            </table>
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <td style="width: 50%;"><b>Payment Address</b></td>
                     <td style="width: 50%;"><b>Shipping Address</b></td>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>
                        <address>
                           {{ $order->payment_address_1 }}<br />{{ $order->payment_address_2 }}<br />{{ $order->payment_city }}<br />{{ $order->payment_state }}<br /> {{ $order->payment_postcode }} <br/> {{ (isset($order->paymentCountry->name)) ? $order->paymentCountry->name : '' }} <br/>
                        </address>
                     </td>
                     <td>
                        <address>
                           {{ $order->shipping_first_name.' '.$order->shipping_last_name }}<br />{{ $order->shipping_company }}<br />{{ $order->shipping_address_1 }} <br/> {{ $order->shipping_address_2 }} <br /> {{ $order->shipping_postcode }} <br /> {{ $order->shipping_state }} <br/> {{ (isset($order->shippingCountry->name)) ? $order->shippingCountry->name : '' }}
                        </address>
                     </td>
                  </tr>
               </tbody>
            </table>
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <td><b>Product</b></td>
                     <td><b>SKU</b></td>
                     <td class="text-right"><b>Quantity</b></td>
                     <td class="text-right"><b>Unit Price</b></td>
                     <td class="text-right"><b>Total</b></td>
                  </tr>
               </thead>
               <tbody>
                <?php
                $subTotal = 0;
                $totalTax=0;
                $totalShipping=0;
                ?>

                   @forelse($order->orderedProducts as $orderedProduct)

                   <?php

                        $individualTotal = $orderedProduct->quantity*$orderedProduct->price;
                        $subTotal += $individualTotal;
                        $totalTax += $orderedProduct->tax;
                        $totalShipping += $orderedProduct->shipping_price;
                    ?>
                  <tr>
                     <td>
                       {{$orderedProduct->product->name}}
                       @if(count($orderedProduct->orderProductOptions)>0)
                       <p><b>Variant</b></p>

                       @foreach($orderedProduct->orderProductOptions ??[] as $orderProductOption)

                        <p>[{{$orderProductOption->productOption->option->name }} : {{($orderProductOption->productOption->option->type == "select")?$orderProductOption->productOptionValue->optionValue->name:$orderProductOption->value}} ]</p>



                        @endforeach
                       @endif

                     </td>
                     <td>{{$orderedProduct->product->sku}}</td>
                     <td class="text-right">{{ $orderedProduct->quantity }}</td>
                     <td class="text-right">{{ $orderedProduct->price }}</td>
                     <td class="text-right">{{ $individualTotal }}</td>
                  </tr>
                  @empty
                  <tr>
                      No data found
                  </tr>
                  @endforelse
                  <tr>
                    <td class="text-right" colspan="4"><b>Sub Total</b></td>
                    <td class="text-right">{{ $subTotal }}</td>
                 </tr>
                 <tr>
                    <td class="text-right" colspan="4"><b>Tax</b></td>
                    <td class="text-right">{{ $totalTax }}</td>
                 </tr>
                 <tr>
                    <td class="text-right" colspan="4"><b>Shipping</b></td>
                    <td class="text-right">{{ $totalShipping }}</td>
                 </tr>
                 <tr>
                    <td class="text-right" colspan="4"><b>Total</b></td>
                    <td class="text-right">{{ ($subTotal+$totalTax+$totalShipping) }}</td>
                 </tr>
               </tbody>
            </table>
         </div>
      </div>
   </body>
</html>

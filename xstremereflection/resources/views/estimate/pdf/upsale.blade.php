<html>
<head>
    <title>Customer Estimate - PDF</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        tr {
            page-break-inside: avoid
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-6">
            <img src="{{ public_path($estimate->customer->company->logo) }}"  width="450px" height="140px" alt="logo"/>
        </div>
        <div class="col-6">
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>Customer</th>
                    <td>{{$customer->firstName ?? 'Unknown Customer'}} {{$customer->lastName ?? ''}}</td>
                </tr>
                <tr>
                    <th>Phone Number</th>
                    <td>@if($customer->phoneNumber) {{ '('.substr($customer->phoneNumber, 0, 3).') '.substr($customer->phoneNumber, 3, 3).'-'.substr($customer->phoneNumber,6)  }} @endif</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{$customer->address ?? ''}}</td>
                </tr>
                <tr>
                    <th>Service Date</th>
                    <td>@if($estimate->dateofService){{\Carbon\Carbon::parse($estimate->dateofService)->format('M d Y')}} @else
                            TBD @endif</td>
                </tr>
                <tr>
                    <th>Arrival Window</th>
                    <td></td>
                </tr>
                @if($estimate->vehicle)
                    <tr>
                        <th>Year</th>
                        <td> {{$estimate->vehicle->vehicleInfo->year}} </td>
                    </tr>
                    <tr>
                        <th>Make</th>
                        <td> {{$estimate->vehicle->vehicleInfo->make}} </td>
                    </tr>
                    <tr>
                        <th>Model</th>
                        <td> {{$estimate->vehicle->vehicleInfo->model}} </td>
                    </tr>
                    <tr>
                        <th>VIN</th>
                        <td> {{$estimate->vehicle->vehicleInfo->vin ?? 'VIN not provided at time of estimate.'}} </td>
                    </tr>
                    <tr>
                        <th>Year</th>
                        <td> {{$estimate->vehicle->vehicleInfo->year}} </td>
                    </tr>

                @endif

                </thead>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-12">

            <table class="table table">
                <thead>
                <tr>
                    <th>Price</th>
                    <th>Product</th>
                    <th>Labor</th>
                    <th>Labor %</th>
                    <th>Acquisition</th>
                    <th>Gross Profit</th>
                    <th>Margin</th>
                    <th>Markup</th>
                </tr>
                </thead>

                <?php
                $price = $estimate->acceptedPackage->chargedPrice;
                $laborPrice = $estimate->acceptedPackage->package->laborCost;
                $productPrice = $estimate->acceptedPackage->package->productCost;
                $acquisitionPrice = $estimate->acceptedPackage->package->acquisitionCost;
                $laborMargin = $laborPrice / $price * 100;
                if ($estimate->detailType == 2) {
                    $costs = $laborPrice + $productPrice + $acquisitionPrice + 25;
                    $gross = $price - $laborPrice - $productPrice - $acquisitionPrice - 25;
                } else {
                    $costs = $laborPrice + $productPrice + $acquisitionPrice;
                    $gross = $price - $laborPrice - $productPrice - $acquisitionPrice;
                }
                $profit = $gross / $price * 100;
                $badProfit = 66 - $profit;
                $markup = $price - $gross / $costs
                ?>
                <tbody>
                <tr class="bg-primary text-white">
                    <td>$ {{$price}}</td>
                    <td>$ {{$productPrice}}</td>
                    <td>$ {{$laborPrice}}</td>
                    <td>{{ceil($laborMargin)}} %</td>
                    <td>$ {{$acquisitionPrice}}</td>
                    <td>$ {{number_format($gross, 2)}}</td>
                    <td>{{number_format($profit)}} %
                        @if($profit < 66) <span class="text-danger"> ( {{number_format($badProfit)}} ) %</span> @endif
                    </td>
                    <td> {{round($markup)}} %</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-striped">
                <?php
                $array = explode(',', $estimate->acceptedPackage->package->upsale);
                $upsale = \Vanguard\Services::whereIn('id', $array)->get();
                ?>

                @if($upsale)
                    @foreach($upsale as $row)
                        <?php
                        $rowPrice = $price + $row->charge;
                        $rowProductPrice = $productPrice + $row->productCost;
                        $rowLaborPrice = $laborPrice + $row->laborCost;

                        $rowLaborMargin = $rowLaborPrice / $rowPrice * 100;
                        $rowCosts = $rowLaborPrice + $rowProductPrice;
                        $rowGross = $rowPrice - $rowLaborPrice - $rowProductPrice;
                        $rowProfit = $rowGross / $rowPrice * 100;
                        $rowBadProfit = 66 - $rowProfit;
                        $rowMarkup = $rowPrice - $rowGross / $rowCosts
                        ?>
                        <tr>
                            <td colspan="7" class="text-center">{{$row->description}}
                                - {{$row->charge}}</td>
                        </tr>
                        <tr>
                            <td>$ {{$rowPrice}}</td>
                            <td>$ {{$rowProductPrice}} ({{$row->productCost ?? '0.00'}})</td>
                            <td>$ {{$rowLaborPrice}} ({{$row->laborCost ?? '0.00'}})</td>
                            <td>{{ceil($rowLaborMargin)}} %</td>
                            <td>$ 0.00</td>
                            <td>$ {{number_format($rowGross, 2)}}</td>
                            <td>{{number_format($rowProfit)}} %
                                @if($rowProfit < 66) <span
                                    class="text-danger"> ( {{number_format($rowBadProfit)}} ) %</span> @endif
                            </td>
                            <td> {{round($rowMarkup)}} %</td>
                        </tr>

                    @endforeach

                @endif

            </table>
        </div>
    </div>

</div>

</body>
</html>

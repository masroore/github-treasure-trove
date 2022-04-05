@if($workOrder->estimate->acceptedPackage->package->laborCost)
<table class="table table">
    <tr>
        <th>Price</th>
        <th>Product</th>
        <th>Labor</th>
        <th>Labor %</th>
        <th>Acquisition</th>
        <th>Bonus</th>
        <th>Gross Profit</th>
        <th>Margin</th>
        <th>Markup</th>
    </tr>

    <?php
    $price = $workOrder->estimate->total;
    $laborPrice = $workOrder->estimate->acceptedPackage->package->laborCost;
    $productPrice = $workOrder->estimate->acceptedPackage->package->productCost;
    $acquisitionPrice = $workOrder->estimate->acceptedPackage->package->acquisitionCost;
    $laborMargin =  ($laborPrice ?? 1) / ($price ?? 1) * 100;
    $costs = $laborPrice + $productPrice + $acquisitionPrice;
    $gross = $price - $laborPrice - $productPrice - $acquisitionPrice;
    $profit = $gross / ($price ?? 1) * 100;
    $markup = $price - $gross / ($costs ?? 1);
    $bonus = $profit - 66 ;
    $bonusAmount = ($bonus ?? 1)  / 100;
    $bonusAmount = $bonusAmount * $gross;
    ?>
    <tr class="bg-primary text-white">
        <td>$ {{$workOrder->estimate->total}}</td>
        <td>$ {{$workOrder->estimate->acceptedPackage->package->productCost}}</td>
        <td>$ {{$workOrder->estimate->acceptedPackage->package->laborCost}}</td>
        <td>{{ceil($laborMargin)}} %</td>
        <td>$ {{$acquisitionPrice}}</td>
        <td>@if($bonus > 0) $ {{number_format($bonusAmount, 2)}} @endif</td>
        <td>$ {{number_format($gross, 2)}}</td>
        <td>{{number_format($profit)}} %</td>
        <td> {{round($markup)}} %</td>
    </tr>
</table>
@endif

<div class="card-body">
    <h5 class="card-title">Package Statistics</h5>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                Package Price Details
            </h5>
            <div class="table-responsive">
                <table class="table table">
                    <thead>
                    <tr>
                        <th>Price</th>
                        <th>Product</th>
                        <th>Labor</th>
                        <th>Labor %</th>
                        <th>Bonus</th>
                        <th>Acquisition</th>
                        <th>Gross Profit</th>
                        <th>Margin</th>
                        <th>Markup</th>
                    </tr>
                    </thead>

                    <?php
                    $price = $package->cost;
                    $laborPrice = $package->laborCost;
                    $productPrice = $package->productCost;
                    $acquisitionPrice = $package->acquisitionCost;
                    $laborMargin = $laborPrice / $price * 100;
                    $costs = $laborPrice + $productPrice + $acquisitionPrice;
                    $gross = $price - $laborPrice - $productPrice - $acquisitionPrice;
                    $profit = ($gross ?? 1) / ($price ?? 1) * 100;
                    $badProfit = 66 - $profit;
                    $markup = $price - $gross / ($costs ?? 1);
                    $bonus = $profit - 66 ;
                    $bonusAmount = ($bonus ?? 1)  / 100;
                    $bonusAmount = $bonusAmount * $gross;
                    ?>
                    <tbody>
                    <tr class="bg-primary text-white">
                        <td>$ {{$price}}</td>
                        <td>$ {{$productPrice}}</td>
                        <td>$ {{$laborPrice}}</td>
                        <td>{{ceil($laborMargin)}} %</td>
                        <td>$ {{$acquisitionPrice}}</td>
                        <td>@if($bonus > 0) $ {{number_format($bonusAmount, 2)}} @endif</td>
                        <td>$ {{number_format($gross, 2)}}</td>
                        <td>{{number_format($profit)}} %
                            @if($profit < 66) <span class="text-danger"> ( {{number_format($badProfit)}} ) %</span> @endif
                        </td>
                        <td> {{round($markup)}} %</td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</div>

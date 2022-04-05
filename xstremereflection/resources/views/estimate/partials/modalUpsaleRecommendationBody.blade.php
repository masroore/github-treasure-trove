<div class="table-responsive">
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
        $array = explode(',', $packages->package->upsale);
        $upsale = \Vanguard\Services::whereIn('id', $array)->get();
        ?>

        @if($upsale)
            @foreach($upsale as $row)
                <?php
                $rowPrice = $price + $row->charge;
                $rowProductPrice = $productPrice + $row->productPrice;
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
                    <td>$ {{$rowProductPrice}}</td>
                    <td>$ {{$rowLaborPrice}}</td>
                    <td>{{ceil($rowLaborMargin)}} %</td>
                    <td>$ 0.00</td>
                    <td>$ {{number_format($rowGross, 2)}}</td>
                    <td>{{number_format($rowProfit)}} %
                        @if($rowProfit < 66) <span class="text-danger"> ( {{number_format($rowBadProfit)}} ) %</span> @endif
                    </td>
                    <td> {{round($rowMarkup)}} %</td>
                </tr>

        @endforeach

        @endif

    </table>
</div>

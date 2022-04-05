@if($estimate->status != 4)
    <div class="row m-2">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body py-0 px-0 px-sm-3">
                    <div class="row">
                        <div class="col-xl-12 text-center">
                            <a href=";javascript" data-toggle="modal" data-target="#packageModal"><img
                                    src="{{ url('assets/img/service.png') }}" height="50" width="50"></a> <br>
                            Add Package
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row ">
    <div class="col-xl-12 ">
        <h2>Packages</h2>
        <div class="card">
            <div class="card-body ">

                <ul class="list-group">
                    <li class="list-group-item mb-3">
                        @if($estimate->packages)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>PKG</th>
                                        <th>Package Description</th>
                                        <th>List Price</th>
                                        <th>Charged Price</th>
                                        <th>Deposit</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($estimate->packages as $packages)
                                        <tr>
                                            <td colspan="6">
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
                                                    $price = $packages->chargedPrice;
                                                    $laborPrice = $packages->package->laborCost;
                                                    $productPrice = $packages->package->productCost;
                                                    $acquisitionPrice = $packages->package->acquisitionCost;
                                                    $laborMargin = $laborPrice / ($price ?? 1) * 100;
                                                    if ($estimate->detailType == 2) {
                                                        $costs = $laborPrice + $productPrice + $acquisitionPrice + 25;
                                                        $gross = $price - $laborPrice - $productPrice - $acquisitionPrice - 25;
                                                    } else {
                                                        $costs = $laborPrice + $productPrice + $acquisitionPrice;
                                                        $gross = $price - $laborPrice - $productPrice - $acquisitionPrice;
                                                    }
                                                    $profit = $gross / ($price ?? 1) * 100;
                                                    $badProfit = 66 - $profit;
                                                    $markup = $price - $gross / ($costs ?? 1)
                                                    ?>
                                                    <tbody>
                                                    <tr class="bg-primary text-white">
                                                        <td>$ {{$price ?? 'Unk'}}</td>
                                                        <td>$ {{$productPrice ?? 'Unk'}}</td>
                                                        <td>$ {{$laborPrice ?? 'Unk'}}</td>
                                                        <td>{{ceil($laborMargin)}} %</td>
                                                        <td>$ {{$acquisitionPrice ?? 'Unk'}}</td>
                                                        <td>$ {{number_format($gross, 2)}}</td>
                                                        <td>{{number_format($profit)}} %
                                                            @if($profit < 66) <span
                                                                class="text-danger"> ( {{number_format($badProfit)}} ) %</span> @endif
                                                        </td>
                                                        <td> {{round($markup)}} %</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>

                                                    @if($estimate->approvedPackage == $packages->id)
                                                        <span class="text-success"><i class="fas fa-check-double"></i></span>
                                                    @else
                                                        <input type="radio" class="form-check-input" name="package"
                                                               id="package{{$packages->ic}}" value="{{$packages->id}}"
                                                               onchange="selectedPackage()"
                                                               @if($estimate->approvedPackage == $packages->id) checked="checked" @endif>
                                                    @endif

                                            </td>
                                            <td width="50%">
                                                {{$packages->package->description ?? 'Unknown Package'}} <br/>
                                                @if($packages->addOnService)
                                                    <table class="table table-sm">
                                                        <tr>
                                                            <th><h6>Add on Services</h6></th>
                                                        </tr>
                                                        @foreach($packages->addOnService as $aos)
                                                            <tr>
                                                                <td>
                                                                    @if($aos->serviceId == 0) {{$aos->description ?? ''}}  @else {{$aos->service->description  }} @endif
                                                                    - <small>List Price:
                                                                        ${{$aos->service->charge ?? '0.00'}}
                                                                        Charged: {{$aos->price ?? '0.00'}} </small>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                @endif

                                            </td>
                                            <td>
                                                $ {{$packages->listPrice ?? ''}}
                                            </td>
                                            <td>
                                                $ {{$packages->chargedPrice ?? ''}}
                                            </td>
                                            <td>
                                                $ {{$packages->deposit ?? ''}}
                                            </td>
                                            <td>
                                                <div class="row">
                                                    @if($estimate->status != 4)
                                                        <div class="col">
                                                            <a href="/removePackage/{{$packages->id}}"><span class="text-danger"><i
                                                                        class="fad fa-eraser"></i></span></a>
                                                        </div>
                                                    @endif
                                                    <div class="col">
                                                        <span data-toggle="tooltip" data-placement="top" title="View package services and add more services.">
                                                            <a data-toggle="modal" data-link="/modal/packageServices/{{$packages->id}}"
                                                               data-target="#servicesModal"><i class="fas fa-binoculars ml-3"></i></a>
                                                        </span>
                                                    </div>
                                                </div>

                                                @if($estimate->approvedPackage)
                                                    <div class="col">
                                                        <span data-toggle="tooltip" data-placement="top" title="Update package price.">
                                                        <a data-toggle="modal"
                                                           data-link="/modal/updatePackage/{{$packages->id}}"
                                                           data-target="#updatePackageModal"><i
                                                                class="far fa-edit"></i></a>
                                                        </span>

                                                    </div>
                                                @endif

                                                <div class="col">
                                                    <span data-toggle="tooltip" data-placement="top" title="View upsale recommendations.">
                                                        <a href="#" data-toggle="modal" data-link="/estimate/package/{{$packages->id}}"
                                                           data-target="#upsaleRecommendationModal">
                                                        <i class="fas fa-cubes"></i>
                                                    </a>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>


                                    </tbody>


                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                    </li>
                    @else
                        <li>
                            <div class="col-xl-2 text-center">
                                No packages added to estimate
                            </div>

                        </li>
                    @endif
                </ul>

            </div>
        </div>
    </div>
</div>

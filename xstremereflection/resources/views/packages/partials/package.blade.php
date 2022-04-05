@foreach($packages as $package)
    <div class="col-xl-3 col-sm-12 ">
        <div class="card full-height">
            <div class="card-content">

                    <div class="card-title">
                        <div class="row mb-1">
                            <div class="col-12">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0">{{$package->description}}</h3>
                                    <p class="text-success ml-2 mb-0 font-weight-medium"> {{count($estimates->where('packageId', $package->id))}} Sold</p>

                                </div>
                            </div>
                            <div class="col-3">
                                <div class="icon icon-box-warning ">
                                    <span class="mdi mdi-arrow-top-right icon-item"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                <div class="card-body">
                    <h6 class="text-muted font-weight-normal">${{$package->cost}}</h6>
                    @if($package->companyId == 0) <h6 class="text-blue font-weight-bold">XR Package</h6> @endif

                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <a href="/package/{{$package->id}}"><button class="btn btn-dark">View Package Details</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endforeach

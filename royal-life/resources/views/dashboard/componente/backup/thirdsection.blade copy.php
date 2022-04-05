<div class="row mb-3">
    <div class="col-12 mt-1">
        {{-- <h2 class="divide-dashboard-title">Red de referidos</h2> --}}
        <div class="col-12">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-start pb-2">
                            <div>
                                <h2 class="text-bold-700">{{$data['directos']}}</h2>
                                <p class="mb-0">Referidos directos</p>
                            </div>
                            <div class="avatar bg-rgba-primary p-50">
                                <div class="avatar-content">
                                    <i class="feather icon-users text-primary font-medium-5"></i>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="card-content">
                            <div id="line-area-chart-5"></div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-start pb-2">
                            <div>
                                <h2 class="text-bold-700">{{$data['indirectos']}}</h2>
                                <p class="mb-0">Referidos en red</p>
                            </div>
                            <div class="avatar bg-rgba-danger p-50">
                                <div class="avatar-content">
                                    <i class="fa fa-users text-danger font-medium-5"></i>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="card-content">
                            <div id="line-area-chart-6"></div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-start pb-2">
                            <div>
                                <h2 class="text-bold-700">${{number_format($data['wallet'], '2', ',', '.')}}</h2>
                                <p class="mb-0">Wallet</p>
                            </div>
                            <div class="avatar bg-rgba-success p-50">
                                <div class="avatar-content">
                                    <i class="fa fa-money text-success font-medium-5"></i>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="card-content">
                            <div id="line-area-chart-7"></div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-start pb-2">
                            <div>
                                <h2 class="text-bold-700">100</h2>
                                <p class="mb-0">Total de Rewards</p>
                            </div>
                            <div class="avatar bg-rgba-success p-50">
                                <div class="avatar-content">
                                    <i class="fa fa-money text-success font-medium-5"></i>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="card-content">
                            <div id="line-area-chart-7"></div>
                        </div> --}}
                    </div>
                </div>



            </div>
        </div>
    </div>

</div>

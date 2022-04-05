<div class="card-body">
    <div class="card-title">
        <div class="row">
            <div class="col-xl-8">
                <h4>Included Packages</h4>
            </div>
            <div class="col-xl-4 text-right">
                @if(Auth()->user()->companyId == 0 || Auth()->user()->companyId == $package->companyId)

                    <a class="text-primary" href=";javascript" data-toggle="modal" data-target="#includedPackageModal"><i
                            class="fas fa-plus-square"></i></a>
                @endif

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <ul class="list-group">
                @if(count($packages))
                    @foreach($packages as $row)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{$row->description}} Package @if($row->companyId == 0) XR Package  @endif
                            @if(Auth()->user()->companyId == 0 || Auth()->user()->companyId == $package->companyId)

                                <a href="/package/packageIncludeRemove/{{$row->id}}/{{$package->id}}" class="text-danger"><i
                                        class="fas fa-trash-alt"></i></a>
                            @endif

                        </li>
                    @endforeach
                @else
                    <li class="list-group-item d-flex justify-content-between align-items-center">No Included Packages
                    </li>
                @endif

            </ul>
        </div>
    </div>
</div>

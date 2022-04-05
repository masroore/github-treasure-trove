<div class="card-body">
    <div class="card-title">
        <div class="row">
            <div class="col-xl-8">
                <h4>Package Services</h4>
            </div>
            <div class="col-xl-4 text-right">
                @if(Auth()->user()->companyId == 0 || Auth()->user()->companyId == $package->companyId)
                    <a class="text-primary" href=";javascript" data-toggle="modal" data-target="#servicesModal"><i class="fas fa-plus-square"></i></a>
                @endif

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <ul class="list-group">
                @foreach($packageServices as $row)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{$row->desc->description}}
                    @if(Auth()->user()->companyId == 0 || Auth()->user()->companyId == $package->companyId)
                    <a href="/package/serviceItemRemove/{{$row->id}}" class="text-danger"><i class="fas fa-trash-alt"></i></a>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
    </div>

</div>

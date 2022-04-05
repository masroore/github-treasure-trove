<div class="card">
    <h5 class="card-header bg-primary">Included Services</h5>
    <div class="card-body">
        <ul class="list-group">

            @if ($package->package->includes)
                <?php $array = explode(',', $package->package->includes); ?>
                @foreach ($array as $include)
                    <?php $services = Vanguard\packageItem::where('packageId', $include)->get(); ?>
                    @foreach ($services as $service)
                        <?php $s = Vanguard\Services::findorFail($service->serviceId); ?>
                        <li class="list-group-item">{{$s->description}}</li>

                    @endforeach
                @endforeach

            @else

                <?php  $services = Vanguard\packageItem::where('packageId', $package->package->id)->get(); ?>
                @foreach ($services as $service)
                    <?php $s = Vanguard\Services::find($service->serviceId); ?>

                    <li class="list-group-item">{{$s->description}}</li>
                @endforeach

            @endif

        </ul>
    </div>
</div>

<div class="card">
    <h5 class="card-header bg-danger">Add On Services</h5>
    <div class="card-body">
        <ul class="list-group">


            <a href="#" data-toggle="modal" data-id="{{$id}}"  data-target="#addServicesModal"><li class="list-group-item active text-center">Add Additional Service</li></a>
        </ul>
    </div>
</div>


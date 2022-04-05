@foreach($estimates as $row)
<tr>
    <td>{{$row->customer->firstName ?? ''}} {{$row->customer->lastName ?? 'Unknown'}}</td>
    <td class="text-center">@if($row->serviceAddress) {{$row->serviceAddress}} @else <i class="fad fa-address-card"></i> @endif</td>
    <td>@if($row->vin) {{substr($row->vehicle->vin, -4)}} @else <i class="fad fa-sort-numeric-up-alt"></i> @endif</td>
    <td>{{$row->vehicle->vehicleInfo->year ?? ''}}</td>
    <td>{{$row->vehicle->vehicleInfo->make ?? ''}}</td>
    <td>{{$row->vehicle->vehicleInfo->trim ?? ''}}</td>
    <td>{{$row->vehicle->vehicleInfo->colorInfo->description ?? '' }}</td>
    <td>@if($row->total)$ {{$row->total ?? 'Not Calculated'}} @else Not Calculated @endif</td>
    <td> @if($row->status == 4) <a href="/workorder/{{$row->workorder->id ?? ''}}/show" > {!! $row->estatus->label ?? '' !!} </a>  @else <a data-toggle="modal" data-target="#statusUpdateModal" data-id="{{$row->id}}" > {!! $row->estatus->label ?? '' !!} </a> @endif</td>
    <td>
        <a href="/estimate/{{$row->id}}/show"><button class="btn btn-outline-primary">View</button></a>
    </td>
</tr>
@endforeach

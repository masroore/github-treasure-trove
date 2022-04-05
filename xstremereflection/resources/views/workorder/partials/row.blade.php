@foreach($workorders as $row)
    <tr>
        <td>{{$row->estimate->customer->firstName ?? ''}} {{$row->estimate->customer->lastName ?? 'Unknown'}}</td>
        @if($row->estimate)
            <td class="text-center">@if($row->estimate->serviceAddress) {{$row->estimate->serviceAddress ?? ''}} @else <i class="fad fa-address-card"></i> @endif</td>
            <td>@if($row->vin) {{substr($row->vehicle->vin, -4)}} @else <i class="fad fa-sort-numeric-up-alt"></i> @endif</td>
            <td>{{$row->estimate->vehicle->vehicleInfo->year ?? ''}}</td>
            <td>{{$row->estimate->vehicle->vehicleInfo->make ?? ''}}</td>
            <td>{{$row->estimate->vehicle->vehicleInfo->trim ?? ''}}</td>
            <td>{{$row->estimate->vehicle->vehicleInfo->colorInfo->description ?? '' }}</td>
            <td>@if($row->totalCharge)$ {{$row->totalCharge ?? 'Not Calculated'}} @else Not Calculated @endif</td>
            <td> {!! $row->wstatus->label ?? '' !!} </td>
        @endif

        <td>
            <a href="/workorder/{{$row->id}}/show"><button class="btn btn-outline-primary">View</button></a>
        </td>
    </tr>
@endforeach

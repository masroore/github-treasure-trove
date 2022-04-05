@foreach($services as $row)
    <tr>
        <td>{{$row->description ?? ''}}</td>
        <td>{{$row->type->descriptiion ?? '' }}</td>
        <td>$ {{number_format($row->charge, 2)}}</td>
        <td class="text-center"> @if($row->status == 1) Active @elseif($row->status == 2) <span class="text-danger">Not Active</span> @endif</td>


    </tr>
@endforeach

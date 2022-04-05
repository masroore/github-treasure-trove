{{-- <a class="met" onclick="tarjeta({{$data}}, '{{route('genealogy_type_id', [strtolower($type), base64_encode($data->id)])}}')"> --}}
<a onclick="tarjeta( {{$data}}, '{{route('genealogy_type_id', [strtolower('matriz'), base64_encode($data->id)])}}')">
    @if (empty($data->photoDB))
        <img src="http://127.0.0.1:8000/assets/img/royal_green/logos/arbol.svg" class="rounded-circle" alt="{{$data->name}}" title="{{$data->name}}" width="55px">
    @else
        <img src="{{asset('storage/photo/'.$data->photoDB)}}" class="rounded-circle" alt="{{$data->name}}" title="{{$data->name}}">
    @endif
</a>


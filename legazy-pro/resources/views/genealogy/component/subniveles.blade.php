<a class="met" onclick="tarjeta({{$data}}, '{{route('genealogy_type_id', [strtolower($type), base64_encode($data->id)])}}')">
    @if (empty($data->photoDB))
        <img src="http://legazypro.com/assets/img/legazy_pro/logo.svg" class="pt-1 rounded-circle" alt="{{$data->name}}" title="{{$data->name}}">
    @else
        <img src="{{asset('storage/photo/'.$data->photoDB)}}" class="rounded-circle" alt="{{$data->name}}" title="{{$data->name}}">
    @endif
</a>
{{--route('genealogy_type_id', [strtolower($type), base64_encode($data->id)])--}} 


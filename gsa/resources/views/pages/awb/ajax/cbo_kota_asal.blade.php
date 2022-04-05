@foreach($kota as $k)
@if($k->id == 9479)
  <option value="{{ $k->id }}" selected>{{ $k->nama }} </option>
@else
  <option value="{{ $k->id }}">{{ $k->nama }} </option>
@endif
@endforeach
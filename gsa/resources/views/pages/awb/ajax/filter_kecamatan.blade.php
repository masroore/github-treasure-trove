@if(count($kecamatan) == 0)
<option value="">Data Kecamatan Belum Tersedia</option>
@else
@foreach($kecamatan as $k)
<option value="{{ $k->id }}">{{ $k->nama }} </option>
@endforeach
@endif
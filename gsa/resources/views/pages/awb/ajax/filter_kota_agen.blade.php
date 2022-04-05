@if(count($kota) > 0)
@foreach($kota as $k)
<option value="{{ $k['agen_id'] }}">{{ $k['agen_nama'] }}</option>
@endforeach
@else
<option value="">Tidak Ada Agen di Kota Yang Anda Pilih</option>
@endif
@foreach($alamat as $a)
  <option value="{{ $a->alamat }}">{{ $a->labelalamat }}</option>
@endforeach
<option value="manual">Input Alamat Manual </option>
@extends('layouts.app')
@section('content')
<div class="card card-custom gutter-b example example-compact">
<div class="card-header">
    <h3 class="card-title">FORM UBAH DATA KOTA </h3>
</div>
<form class="form" method="POST" 
@if ($kota->id == 0)
action="{{url('master/kota/save')}}"
@else
action="{{url('master/kota/update')}}"
@endif    
>      
<input type="hidden" name="id" value="{{ $kota->id }}">
{{ csrf_field() }}
<div class="card-body">
    <div class="row">
        <div class="form-group col-lg-6">
            <label>Kode Kota:</label>
            <input type="text" required class="form-control" name="kode" value="{{ (old('kode') && old('kode') !='') ?old('kode'): $kota->kode  }}"  maxlength="3"/>        
        </div>
        <div class="form-group col-lg-6">
            <label>Nama Kota:</label>
            <input type="text" required class="form-control" name="nama" value="{{ (old('nama') && old('nama') !='') ?old('nama'): $kota->nama  }}" />        
        </div>
        <div class="form-group col-lg-6">
            <label>Keterangan:</label>
            <textarea   class="form-control" name="keterangan" value="{{ $kota->keterangan}}" />{{ (old('keterangan') && old('keterangan') !='') ?old('keterangan'): $kota->keterangan  }}</textarea>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="submit" id='simpanbutton' class="btn btn-primary mr-2">SIMPAN</button>
                @if ($kota->id == 0)<button type="reset" class="btn btn-secondary">Cancel</button>@endif
            </div>
        </div>
    </div>
    </form>
</div>
@endsection
@section('script')
<script type="text/javascript"> </script>
@if(Session::get('message') == "kodesudahada")
<script type="text/javascript">
    toastr.error("Kode kota sudah ada!");
</script>
@endif
@endsection
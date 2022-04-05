@extends('layouts.app')
@section('content')
<div class="card card-custom gutter-b example example-compact">
<div class="card-header">
    <h3 class="card-title">FORM ALAMAT </h3>
</div>
<form class="form" method="POST" action="{{url('master/alamat/save')}}" 
>      
<input type="hidden" name="id" value="{{ $alamat->id }}">
{{ csrf_field() }}
<div class="card-body">
    <div class="row">
        <div class="form-group col-lg-6">
            <label>Label Alamat:</label>
            <input type="hidden"   class="form-control" id='oa' name="oa" value="{{ (old('oa') && old('oa') !='') ?old('oa'): $alamat->oa  }}" />        
            <input type="text" required class="form-control" name="labelalamat" value="{{ (old('labelalamat') && old('labelalamat') !='') ?old('labelalamat'): $alamat->labelalamat  }}" />        
        </div>
        <div class="form-group col-lg-6">
            <label>nama Penerima:</label>
             <input type="text" required class="form-control" name="nama_penerima" value="{{ (old('nama_penerima') && old('nama_penerima') !='') ?old('nama_penerima'): $alamat->nama_penerima  }}" />        
        </div>
        <div class="form-group col-lg-6">
            <label>no telp:</label>
             <input type="text" required class="form-control" name="no_hp" value="{{ (old('no_hp') && old('no_hp') !='') ?old('no_hp'): $alamat->no_hp  }}" />        
        </div>
        <div class="form-group col-lg-6">
            <label>Alamat:</label>
            <input type="text" required class="form-control" name="alamat" value="{{ (old('alamat') && old('alamat') !='') ?old('alamat'): $alamat->alamat  }}" />        
        </div>  
        <div class="form-group col-lg-6">
            <label>kodepos:</label>
            <input type="text" required class="form-control" name="kodepos" value="{{ (old('kodepos') && old('kodepos') !='') ?old('kodepos'): $alamat->kodepos  }}" />        
        </div> 
        @if (((int)Auth::user()->level==1))
            <div class="form-group col-lg-6" id='groupcustomer'>
                <label>Belongs to Customer:</label>
                <select class="custom-select"  name="pelanggan_id" id="pelanggan_id">
                    <option value='' >Choose...</option>
                    @foreach ($customer as $item)
                        <option 
                            @if($item->id == $alamat->pelanggan_id)
                                selected
                            @endif
                            value="{{$item->id}}">{{$item->kode}} - {{$item->nama}}</option>
                    @endforeach
                </select>        
            </div>     
        @endif        
        <div class="form-group col-lg-6">
            <label>Kota:</label>
            <select type="text" required class="form-control select2 required" id='kota' name="idkota" >
                @foreach($kota as $k)
                    @if($k->id == $alamat->idkota )
                        <option value="{{ $k->id }}" selected>{{ $k->nama }} </option>
                    @else
                        <option value="{{ $k->id }}">{{ $k->nama }} </option>
                    @endif
                @endforeach
              </select>
        </div> 
        <div class="form-group col-lg-6">
            <label>Kecamatan:</label>
            <select required class="form-control" id='kecamatan' name="kecamatan" >
                <option class=" " value="" selected>Pilih - Kecamatan </option>
                @foreach($kecamatan as $k)
                    @if($k->nama == $alamat->kecamatan )
                        <option oa = "{{$k->oa}}" class="kotashow kota_{{$k->idkota}}" value="{{ $k->id }}" selected>{{ $k->nama }} </option>
                    @else
                        <option oa = "{{$k->oa}}" class="kotashow kota_{{$k->idkota}}" value="{{ $k->id }}">{{ $k->nama }} </option>
                   @endif
                @endforeach
              </select>
        </div> 
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6">
                <button type="submit" id='simpanbutton' class="btn btn-primary mr-2">SIMPAN</button>
                @if ($alamat->id == 0)<button type="reset" class="btn btn-secondary">Cancel</button>@endif
            </div>
        </div>
    </div>
    </form>
</div>
@endsection
@section('script')
<script type="text/javascript"> 
    // $('.kotashow').hide() 
    showkecamatan()
    $('#kota').change(function(){
        showkecamatan()       
        $('#kecamatan').val('');
        $('#oa').val(0)
    })
   function showkecamatan(){
        var id=$('#kota').val();
        $('.kotashow').hide();
        $('.kota_'+id).show();
   }
   $('#kecamatan').change(function(){
       $('#oa').val($('option:selected', this).attr('oa'))
   })
</script>
@if(Session::get('message') == "kodesudahada")
<script type="text/javascript">
    toastr.error("Kode kota sudah ada!");
</script>
@endif
@endsection
@extends('layouts.app')
@section('content')
<div class="card card-custom gutter-b example example-compact">
  <div class="card-header">
    <h3 class="card-title">FORM TAMBAH DATA CUSTOMER </h3>
  </div>
<form class="form" method="POST" action="{{ url('master/customer/save')}}">
  {{ csrf_field() }}
  <div class="card-body">
   <div class="row">
    <div class="col-lg-6">
      <div class="form-group">
        <label>Nama Customer:</label>
        <input type="text" class="form-control" name="nama" placeholder="Input nama customer. . . " required/>
      </div>
      <div class="form-group">
       <label>Kota:</label>
       <select type="text" class="form-control select2" name="idkota" required>
         @foreach($kota as $k)
          @if($k->id == "3578")
            <option value="{{ $k->id }}" selected>{{ $k->nama }} </option>
            @else
            <option value="{{ $k->id }}">{{ $k->nama }} </option>
            @endif
         @endforeach
       </select>
     </div>
    <div class="form-group">
     <label>Alamat Customer:</label>
     <input type="text" class="form-control" name="alamat" placeholder="Input alamat customer. . ." required/>
   </div>
   <div class="form-group">
     <label>Nomor Telepon Customer:</label>
      <input type="text" class="form-control" name="notelp" placeholder="Input nomor telepon customer. . ." required/>
    </div>

    <div class="form-group">
      <label>Kode Customer:</label>
       <input type="text" class="form-control" name="kode" placeholder="Input kode customer. . ." required/>
     </div>

     <div class="form-group">
      <label>Kode Pos Customer:</label>
      <input type="text" class="form-control" name="kodepos" placeholder="Input kodepos customer. . ." />
    </div>
    
    
    <div class="form-group">
      <label>Jenis Out Area</label>
      <div class="radio-inline">
        <label class="radio">
        <input type="radio" name="jenis_out_area" value="shipment" required>
        <span></span>Per Shipment</label>
        <label class="radio">
        <input type="radio" name="jenis_out_area" value="resi" required>
        <span></span>Per Resi</label>
        <label class="radio">
        <input type="radio" name="jenis_out_area" value="koli" required>
        <span></span>Per Koli</label>
      </div>
      <span class="form-text text-muted">Pilih Jenis Out Area</span>
    </div>
    
    <div class="form-group">
      <label>Hak Akses Mengubah Satuan</label>
      <div class="checkbox-inline">
        <label class="checkbox checkbox-lg">
        <input name="access" type="checkbox">
        <span></span>Berikan hak akses</label>
      </div>
      <span class="form-text text-muted">Centang untuk memberikan hak akses untuk mengubah satuan</span>
    </div>

    
     {{-- <div class="form-group">
      <label>Rekening:</label>
       <input type="text" class="form-control" name="rekening" placeholder="Input Nomor Rekening. . ."/>
     </div>

     <div class="form-group">
      <label>Bank :</label>
       <input type="text" class="form-control" name="bank" placeholder="Input bank. . ."/>
     </div>
     
     <div class="form-group">
      <label>Rekening Atas Nama (a/n):</label>
       <input type="text" name="rekeningatasnama" class="form-control" placeholder="Input Nomor Atas Nama Rekening. . ."/>
     </div> --}}
     

   </div>
   <div class="col-lg-6">
     
    <div class="form-group">
      <label>Harga Koli Kecil:</label>
      <input type="text" class="form-control rupiah" name="harga_koli_k" placeholder="Input harga koli kecil. . ." required/>
    </div>
    <div class="form-group">
      <label>Harga Koli Sedang:</label>
      <input type="text" class="form-control rupiah" name="harga_koli_s" placeholder="Input harga koli sedang. . ." required/>
    </div>
    
    <div class="form-group">
      <label>Harga Koli Besar:</label>
      <input type="text" class="form-control rupiah" name="harga_koli_b" placeholder="Input harga koli besar. . ." required/>
    </div>
    
    <div class="form-group">
      <label>Harga Koli Besar banget:</label>
      <input type="text" class="form-control rupiah" name="harga_koli_bb" placeholder="Input harga koli besar banget. . ." required/>
    </div>

     <div class="form-group">
      <label>Harga Out Area:</label>
       <input type="text" class="form-control rupiah"  name="harga_oa" placeholder="Input harga out area. . ." required/>
     </div>

    <div class="form-group">
      <label>Harga per 5 Kg Pertama:</label>
       <input type="text" class="form-control rupiah" name="harga_kg" placeholder="Input harga per 5 Kg Pertama. . ." required/>
     </div>

    <div class="form-group">
      <label>Harga Per Dokumen:</label>
       <input type="text" class="form-control rupiah" name="harga_doc" placeholder="Input harga per dokumen. . ." required/>
     </div>

     <div class="form-group">
       <label>Harga Kg Selanjutnya:</label>
        <input type="text" class="form-control rupiah" name="harga_kg_selanjutnya" placeholder="Input harga kg selanjutnya. . ." required/>
      </div>
     
   
   <div class="form-group">
    <label>Customer ini adalah agen</label>
    <div class="checkbox-inline">
      <label class="checkbox checkbox-lg">
      <input name="is_agen" type="checkbox" id="is_agen">
      <span></span>Ya</label>
    </div>
    <span class="form-text text-muted">Centang untuk menandai customer ini sebagai agen</span>
  </div>
  <div class="form-group" id="id_agen_div">
    <label>Belongs to agen</label>
    
    <select type="text" class="form-control select2" id="id_agen" name="id_agen" required>
      <option value="">--Pilih Agen--</option>
      @foreach($agen as $a)
       @if($k->id == "3578")
         <option value="{{ $a->id }}" selected>{{ $a->nama }} </option>
         @else
         <option value="{{ $a->id }}">{{ $a->nama }} </option>
         @endif
      @endforeach
    </select>
  </div>
   </div>
  </div>
  <div class="card-footer">
   <div class="row">
    <div class="col-lg-6">
     <button type="submit" class="btn btn-primary mr-2">SIMPAN</button>
     <button type="reset" class="btn btn-secondary">Cancel</button>
    </div>
   </div>
  </div>
 </form>
</div>
@endsection

@section('script')
<script>
  $('#id_agen_div').hide();
  $('#id_agen').removeAttr("required")
  $('#is_agen').change(function() {
    console.log(this.checked);
    if(this.checked){
      $('#id_agen_div').show();
      $('#id_agen').attr("required","true")
    }
    else{
      $('#id_agen_div').hide();
      $('#id_agen').removeAttr("required")
    }
  })
</script>
@endsection
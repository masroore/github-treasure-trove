@extends('layouts.app')
@section('content')

<div class="card card-custom gutter-b example example-compact">
  <div class="card-header">
    <h3 class="card-title">Form Pengisian AWB </h3>
  </div>
<form class="form" method="POST" action="{{ url('awb/save')}}">
  {{ csrf_field() }}
  <div class="card-body">
    <div class="row">
        <div class="card-body mb-5">
          <h6 class="panel-title txt-dark" style="border-bottom:1px solid #EBEDF3;"><i class="flaticon-profile-1"> </i> Data Umum Pengiriman</h6>
          <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  <label>Customer</label>
                  <select style="width:90%" class="select2 form-control" name="id_customer" required>
                    @if(Auth::user()->level == 1)
                    <option value="">--Pilih Customer--</option>
                    @foreach($customer as $c)
                      <option value="{{ $c->id }}">{{ $c->nama }}</option>
                    @endforeach
                    @else
                      <option value="{{ $customer->id }}" selected>{{ $customer->nama }}</option>
                    @endif
                  </select>
                </div>
              </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Nomor AWB:</label>
                    <input name="noawb" type="text" class="form-control" name="nama" placeholder="Input nomor awb. . . " required>
                  </div>
                </div>
                
                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Tanggal:</label>
                    <div class="input-group date">
                      <input name="tanggal_awb" type="text" class="form-control datepicker" value="{{ date('m/d/Y') }}" readonly="true" placeholder="Select date">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="la la-calendar-check-o"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
      </div>
    </div>
    <div class="row">
      
      <div class="card-body">
        <h6 class="panel-title txt-dark"><i class="flaticon-shopping-basket"> </i>Data Jumlah Barang</h6>
        <div class="row">
          @if(Auth::user()->level !== 1 && $customer->can_access_satuan !== 1)
          <div class="col-lg-4">
            <div class="form-group">
              <label>Qty</label>
              <input type="number" class="form-control" name="qty" placeholder="Input jumlah koli kecil. . ." value="0">
            </div>
          </div>
          @else
          <div class="col-lg-4">
            <div class="form-group">
              <label>Qty Koli Kecil</label>
              <input type="number" class="form-control" name="qty_kecil" placeholder="Input jumlah koli kecil. . ." value="0">
            </div>
          </div>
          <div class="col-lg-4">
            
            <div class="form-group">
              <label>Qty Koli Sedang</label>
              <input type="number" class="form-control" name="qty_sedang" placeholder="Input jumlah koli sedang. . ." value="0">
            </div>
          </div>
          <div class="col-lg-4">
            
            <div class="form-group">
              <label>Qty Koli Besar</label>
              <input type="number" class="form-control" name="qty_besar" placeholder="Input jumlah koli besar. . ." value="0">
            </div>
          </div>
          <div class="col-lg-4">
            
            <div class="form-group">
              <label>Qty Koli Besar Banget</label>
              <input type="number" class="form-control" name="qty_besar_banget" placeholder="Input jumlah koli besar_banget. . ." value="0">
            </div>
          </div>
          <div class="col-lg-4">
            
            <div class="form-group">
              <label>Qty Koli Kg</label>
              <input type="number" class="form-control" name="qty_kg" placeholder="Input jumlah koli kg. . ." value="0">
            </div>
          </div>
          <div class="col-lg-4">
            
            <div class="form-group">
              <label>Qty Koli Dokumen</label>
              <input type="number" class="form-control" name="qty_doc" placeholder="Input jumlah koli dokumen. . ." value="0">
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
    
    <div class="row">
      
      <div class="card-body">
        <h6 class="panel-title txt-dark"><i class="flaticon-truck"> </i>Data Alamat Pengiriman</h6>
        <br>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label>Nama Penerima</label>
              <input type="text" class="form-control" name="nama_penerima" placeholder="Input Nama Penerima. . ." required>
            </div>
            <div class="form-group">
              <label>Alamat Tujuan Penerima</label>
              <input type="text" class="form-control" name="alamat_tujuan" placeholder="Input Alamat tujuan. . ." required>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>Kode Pos Penerima</label>
              <input type="text" class="form-control" name="kodepos_penerima" placeholder="Input Kode Pos. . ." required>
            </div>
            <div class="form-group">
              <label>No Telp Penerima</label>
              <input type="text" class="form-control" name="notelp_penerima" placeholder="Input Nomor Telp Penerima. . ." required>
            </div>
          </div>
      </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label>Kota Asal</label>
              <select style="width:90%" class="select2 form-control" id="kota_asal" name="id_kota_asal" readonly="true" required>
                <option value="">--Pilih Kota Asal--</option>
                @foreach($kota as $c)
                  <option value="{{ $c->id }}">{{ $c->nama }}</option>
                @endforeach
              </select>
            </div>
            
            
            @if(Auth::user()->level == 1)
            <div class="form-group">
              <label>Agen Asal</label>
              <select style="width:90%" class="select2 form-control"  id="agen_asal" name="id_agen_asal" required>
                <option value="">--Pilih Kota Asal Terlebih Dahulu--</option>
              </select>
              <span class="form-text text-warning">Opsi Agen Asal akan muncul otomatis sesuai dengan pilihan Kota Asal</span>
           
            </div>
            <div class="form-group">
              <label>Kota Transit</label>
              <select style="width:90%" class="select2 form-control" name="id_kota_transit" >
                <option value="">--Pilih Kota Transit--</option>
                @foreach($kota as $c)
                  <option value="{{ $c->id }}">{{ $c->nama }}</option>
                @endforeach
              </select>
            </div>
            @endif
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>Kota Tujuan</label>
              <select style="width:90%" class="select2 form-control" id="kota_tujuan" name="id_kota_tujuan" required>
                <option value="">--Pilih Kota Tujuan--</option>
                @foreach($kota as $c)
                  <option value="{{ $c->id }}">{{ $c->nama }}</option>
                @endforeach
              </select>
            </div>

            @if(Auth::user()->level == 1)
            <div class="form-group">
              <label>Agen Tujuan</label>
              <select style="width:90%" class="select2 form-control" id="agen_tujuan" name="id_agen_penerima" required>
                <option value="">--Pilih  Kota Tujuan Terlebih Dahulu--</option>
              </select>
              <span class="form-text text-warning">Opsi Agen Tujuan akan muncul otomatis sesuai dengan pilihan Kota Tujuan</span>
            </div>
            <div class="form-group">
              <label>Status Out Area </label>
              <label class="checkbox checkbox-danger">
                <input type="checkbox" name="charge_oa">
                <span></span>Kenakan Charge Out Area</label>
                <span class="form-text text-muted">Biaya Out Area Customer akan ditambahkan ketika dikenakan charge out area</span>
            </div>
            @endif
          </div>

        </div>
        
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group">
              <label>Keterangan tambahan :</label>
              <textarea name="keterangan" rows="4" class="form-control" required></textarea>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <div class="card-footer d-flex justify-content-between">
    <button type="submit" class="btn btn-primary mr-2">SIMPAN</button>
    <input style="width:500px;" type="text" class="form-control" name="harga_total" id="harga_total" readonly="true" placeholder="0" >
  </div>
</form>
</div>
@endsection
@section('script')
<script>
  $('#kota_asal').on('change',function(){
    $.ajax({
      method:'POST',
      url:'{{ url("awb/filter-kota-agen") }}',
      data:{
        kota_id: $(this).val(),
        '_token': $('input[name=_token]').val()
      },
      success:function(data){
        console.log(data);
        $('#agen_asal').html(data.view);
      }
    })
  })
  $('#kota_tujuan').on('change',function(){
    $.ajax({
      method:'POST',
      url:'{{ url("awb/filter-kota-agen") }}',
      data:{
        kota_id: $(this).val(),
        '_token': $('input[name=_token]').val()
      },
      success:function(data){
        console.log(data);
        $('#agen_tujuan').html(data.view);
      }
    })
  })
  
</script>
@endsection
<div class="row">
  <div class="col-md-6">
    <table class="table table-bordered table-hover table-striped">
      <tr>
        <th>Nomor AWB</th>
        <td>{{ $awb->noawb }}</td>
      </tr> 
      <tr>
        <th>Tanggal AWB</th>
        <td>{{ date('d F Y',strtotime($awb->tanggal_awb) ) }}</td>
      </tr>
    </table>
  </div>
  <div class="col-md-6">
    <table class="table table-bordered table-hover table-striped">
    <tr>
        <th colspan="6" class="text-center">Qty </th>
    </tr>
    @if($awb->is_agen == 1)
    <tr>
      <th class="text-center"><u>{{ $awb->qty }} </u></th>
    </tr>
    @else
    <tr>
      <th>Kecil</th>
      <th>Sedang</th>
      <th>Besar</th>
      <th>BB</th>
      <th>Kg</th>
      <th>Doc</th>
    </tr>
    <tr>
      <th>{{ $awb->qty_kecil }}</th>
      <th>{{ $awb->qty_sedang }}</th>
      <th>{{ $awb->qty_besar }}</th>
      <th>{{ $awb->qty_besarbanget }}</th>
      <th>{{ $awb->qty_kg }}</th>
      <th>{{ $awb->qty_doc }}</th>
    </tr>
    @endif
  </table>
</div>
  
</div>
<div class="row">
  <div class="col-md-6">
    <table class="table table-bordered table-hover table-striped">
      <tr>
        <th>Nama Pengirim</th>
        <td>{{ $awb->nama_pengirim }}</td>
      </tr> 
      <tr>
        <th>Alamat Pengirim</th>
        <td>{{ $awb->alamat_pengirim }}</td>
      </tr>
      <tr>
        <th>No Telp Pengirim</th>
        <td>{{ $awb->notelp_pengirim }}</td>
      </tr>
      <tr>
        <th>Kodepos Pengirim</th>
        <td>{{ $awb->kodepos_pengirim }}</td>
      </tr>
    </table>
  </div>
  <div class="col-md-6">
      <table class="table table-bordered table-hover table-striped">
        <tr>
          <th>Nama Penerima</th>
          <td>{{ $awb->nama_penerima }}</td>
        </tr> 
        <tr>
          <th>Alamat Penerima</th>
          <td>{{ $awb->alamat_tujuan }}</td>
        </tr>
        <tr>
          <th>No Telp Penerima</th>
          <td>{{ $awb->notelp_penerima }}</td>
        </tr>
        <tr>
          <th>Kodepos Penerima</th>
          <td>{{ $awb->kodepos_penerima }}</td>
        </tr>
      </table>
  </div>
</div>

  
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered table-striped table-hover">
      <tr>
        <th>Kota Asal</th>
        <td>{{ $kota_asal->nama }} ({{ $kota_asal->kode }})</td>
      </tr>
      {{-- @if(!empty($kota_transit) && Auth::user()->level == "1")
      <tr>
        <th>Kota Transit</th>
        <td>{{ $kota_tujuan->nama }} ({{ $kota_tujuan->kode }})</td>
      </tr>
      @endif --}}
      <tr>
        <th>Kota Tujuan</th>
        <td>{{ $kota_tujuan->nama }} ({{ $kota_tujuan->kode }})</td>
      </tr>
    </table>
  </div>
</div>
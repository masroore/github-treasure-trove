<div class="modal fade" id="modal-koli" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Informasi Quantity AWB Nomor 
            <span class="label label-lg label-dark label-inline" id="noawb_koli"></span>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered table-hovered table-striped" id="table-not-agen">
            @if($is_akses_qty == "true")
            <tr>
              <td style="width: 40%;">Koli Kecil </td>
              <th id="kecil"> </th>
            </tr><tr>
              <td style="width: 40%;">Koli Sedang </td>
              <th id="sedang"> </th>
            </tr><tr>
              <td style="width: 40%;">Koli Besar </td>
              <th id="besar"> </th>
            </tr><tr>
              <td style="width: 40%;">Koli Besar Banget </td>
              <th id="besarbanget"> </th>
            </tr><tr>
              <td style="width: 40%;">Koli Dokumen </td>
              <th id="doc"> </th>
            </tr>
            <tr>
              <td style="width: 40%;">Koli Kg </td>
              <th id="kg"> </th>
            </tr>
            @elseif($is_akses_qty == "false")
            <tr style="">
              <th style="width: 40%;">Total </th>
              <th > <b><em id="qty"></em></b> </th>
            </tr>
            @endif
            <tr>
              <td>Total Harga </td>
              <th>
                <strong class="minus_harga"></strong>
                <strong class="total_harga"></strong>
              </th>
            </tr>
            <tr>
              <td>Harga Charge</td>
              <th>
                <strong class="minus_harga"></strong>
                <strong class="harga_charge"></strong>
              </th>
            </tr>
            @if((int)Auth::user()->level == 1)
            <tr>
              <td> <strong class="text-warning">Harga Gsa </strong></td>
              <th><strong class="harga_gsa text-warning"></strong></th>
            </tr>
            @endif
            <tr>
              <td>Total OA </td>
              <th><strong class="total_oa"></strong></th>
            </tr>
          </table>
          <table class="table table-bordered table-hovered table-striped" id="table-agen">
            <tr style="">
              <th style="width: 40%;">Total </th>
              <th > <b><em id="qty"></em></b> </th>
            </tr>
            <tr>
              <td>Total Harga </td>
              <th>
                <strong class="minus_harga"></strong>
                <strong class="total_harga"></strong></th>
            </tr>
            <tr>
              <td>Total OA </td>
              <th><strong class="total_oa"></strong></th>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Tutup</button>
        </div>
      </div>
  </div>
</div>
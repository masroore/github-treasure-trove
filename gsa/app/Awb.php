<?php

namespace App;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Awb extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'awb';

    protected static $logAttributes = ['noawb', 'id_customer', 'id_kota_tujuan', 'id_kota_asal', 'id_kota_transit', 'id_agen_asal', 'id_agen_penerima', 'charge_oa', 'alamat_tujuan', 'notelp_penerima', 'nama_penerima', 'nama_pengirim', 'keterangan', 'total_harga', 'tanggal_awb', 'status_invoice', 'status_tracking', 'status_manifest', 'status_paid_agen', 'qty_kecil', 'qty_sedang', 'qty_besar', 'qty_besarbanget', 'qty_kg', 'qty_doc', 'qty', 'created_by', 'updated_by', 'kodepos_penerima', 'idr_oa', 'id_manifest', 'id_invoice', 'kodepos_pengirim', 'notelp_pengirim', 'alamat_pengirim', 'tanggal_diterima', 'id_kecamatan_tujuan', 'deleted_at', 'is_agen', 'ada_faktur', 'referensi', 'jenis_koli', 'labelalamat', 'harga_kg_pertama', 'harga_kg_selanjutnya', 'jenis_oa', 'harga_charge', 'harga_gsa', 'jumlah_koli'];

    protected $fillable = [
        'noawb', 'id_customer', 'id_kota_tujuan', 'id_kota_asal', 'id_kota_transit', 'id_agen_asal', 'id_agen_penerima', 'charge_oa', 'alamat_tujuan', 'notelp_penerima', 'nama_penerima', 'nama_pengirim', 'keterangan', 'total_harga', 'tanggal_awb', 'status_invoice', 'status_tracking', 'status_manifest', 'status_paid_agen', 'qty_kecil', 'qty_sedang', 'qty_besar', 'qty_besarbanget', 'qty_kg', 'qty_doc', 'qty', 'created_by', 'updated_by', 'kodepos_penerima', 'idr_oa', 'id_manifest', 'id_invoice', 'kodepos_pengirim', 'notelp_pengirim', 'alamat_pengirim', 'tanggal_diterima', 'id_kecamatan_tujuan', 'created_at', 'deleted_at', 'is_agen', 'ada_faktur', 'referensi', 'jenis_koli', 'labelalamat', 'harga_kg_pertama', 'harga_kg_selanjutnya', 'jenis_oa', 'harga_charge', 'harga_gsa', 'jumlah_koli',
    ];

    public static function getNoAwb()
    {
        $res = DB::table('awb')->count();

        return sprintf('%08s', $res);
    }

    public static function cek_penerima_kosong()
    {
        $data = DB::SELECT("
                    select history_scan_awb.iduser,awb.*
                    from awb
                    join history_scan_awb on history_scan_awb.idawb = awb.id and history_scan_awb.tipe = 'complete'
                    where awb.status_tracking='complete'
                    and history_scan_awb.iduser = " . (int) Auth::user()->id . "
                    and awb.created_at >= '2021-10-15 00:00:00'
                    and (awb.diterima_oleh = '' or awb.diterima_oleh IS NULL)");

        return $data;
    }
}

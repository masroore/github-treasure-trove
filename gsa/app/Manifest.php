<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Manifest extends Model
{
    use LogsActivity;

    protected $table = 'manifest';

    protected static $logAttributes = ['kode', 'id_kota_asal', 'id_kota_tujuan', 'tanggal_pengiriman', 'dicek_oleh', 'supir', 'id_agen_penerima', 'jumlah_kg', 'jumlah_koli', 'keterangan', 'created_by', 'updated_by', 'status', 'dibuat_oleh', 'jumlah_doc', 'tanggal_diterima', 'discan_terima_oleh', 'discan_diterima_oleh_nama', 'agen_tujuan'];

    public static function getNoManifest()
    {
        $res = DB::table('manifest')->count();

        return 'MNFST/' . sprintf('%08s', $res) . self::randomChar();
    }

    public static function randomChar()
    {
        $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        shuffle($seed);
        $rand = '';
        foreach (array_rand($seed, 3) as $k) {
            $rand .= $seed[$k];
        }

        return $rand;
    }
}

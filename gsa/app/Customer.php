<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Customer extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'customer';

    protected static $logAttributes = ['nama', 'notelp', 'alamat', 'harga_koli_k', 'harga_koli_s', 'harga_koli_b', 'harga_koli_bb', 'harga_kg', 'harga_doc', 'harga_oa', 'rekening', 'bank', 'rekeningatasnama', 'can_access_satuan', 'jenis_out_area', 'kode', 'idkota', 'kodepos', 'is_agen', 'id_agen', 'harga_kg_selanjutnya'];

    protected $fillable = [
        'nama', 'notelp', 'alamat', 'harga_koli_k', 'harga_koli_s', 'harga_koli_b', 'harga_koli_bb', 'harga_kg', 'harga_doc', 'harga_oa', 'rekening', 'bank', 'rekeningatasnama', 'can_access_satuan', 'jenis_out_area', 'kode', 'idkota', 'kodepos', 'is_agen', 'id_agen', 'harga_kg_selanjutnya',
    ];
}

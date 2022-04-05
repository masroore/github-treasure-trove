<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class ImportantSetting extends Model
{
    use EncryptationId;

    protected $table = 'important_settings';

    protected $fillable = ['id', 'access_history_id', 'process_id', 'date_access', 'processed_data'];

    protected $connection = 'mysql';

    protected $appends = ['crypt_id', 'name_process', 'data_formate'];

    public $timestamps = false;

    public function getNameProcessAttribute()
    {
        return __('menu.' . $this->getProcess->name_process);
    }

    public function getDataFormateAttribute()
    {
        if ($this->date_access == null || $this->date_access == '') {
            return date('d/m/Y H:i:s');
        }
        $date = explode(' ', $this->date_access);
        $f = explode('-', $date[0]);

        return $f[2] . '/' . $f[1] . '/' . $f[0] . ' ' . $date[1];
    }

    public function getProcess()
    {
        return $this->belongsTo('App\Models\Process', 'process_id');
    }
}

<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    use EncryptationId;

    protected $table = 'models';

    protected $fillable = ['id', 'serial', 'weight', 'color', 'quantity', 'price', 'status', 'trade_mark_id', 'user_id', 'date_register', 'ip'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['mark', 'crypt_id', 'name_model', 'change_status_models'];

    public function getTradeMark()
    {
        return $this->belongsTo(TradeMark::class, 'trade_mark_id');
    }

    public function getMarkAttribute()
    {
        return $this->getTradeMark->name_trade_mark;
    }

    public function getNameModelAttribute()
    {
        return $this->getTradeMark->name_trade_mark . ' ' . $this->serial;
    }

    public function getBoxes()
    {
        return $this->hasMany(PosBoxe::class, 'model_id');
    }

    public function getChangeStatusModelsAttribute()
    {
        $changeModel = '';
        if ($this->status == 1) {
            $changeModel = 'Activo';
        } else {
            $changeModel = 'Inactivo';
        }

        return $changeModel;
    }
}

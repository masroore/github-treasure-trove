<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Detailqtyscanned extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['qty_ke', 'qty_ori', 'status', 'idawb'];

    protected $table = 'detail_qty_scanned';
}

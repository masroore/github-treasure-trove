<?php

namespace App\Models\Operations;

use Illuminate\Database\Eloquent\Model;

class AcItemDetail extends Model
{
    protected $table = 'tbl_ac_detail_item';

    public $timestamps = false;

    public static function getACDetailItem($AC_Item)
    {
        $query = static::query();
        if (null !== $AC_Item) {
            $query->where('AC_Item', $AC_Item);
        }

        $result = $query->get();

        return $result;
    }
}

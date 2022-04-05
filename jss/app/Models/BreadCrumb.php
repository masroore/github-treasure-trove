<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreadCrumb extends Model
{
    use HasFactory;

    protected $table = 'tb_menu';

    public static function getBreadCrumb($url)
    {
        $retVal = [];
        $parentId = 100000;
        $childId = self::where('controller', $url)->where('parentId', '!=', 0)->first();
        if ($childId == null) {
            return [];
        }
        $prevCtr = $childId->controller;
        $childId = $childId->id;

        while (true) {
            $parentId = self::where('id', $childId)->first();
            if ($parentId == null) {
                break;
            }

            if (isset($parentId)) {
                $childId = $parentId->parentId;
                if (trim($parentId->controller) == '') {
                    $tmp = self::where('parentId', $parentId->id)->orderBy('id', 'asc')->get();
                    if (isset($tmp) && count($tmp) > 0 && $tmp[0] != '') {
                        $parentId->controller = $tmp[0]->controller;
                    } else {
                        $parentId->controller = $prevCtr;
                    }
                }
                $retVal[] = $parentId;
            }

            if ($parentId->controller != '') {
                $prevCtr = $parentId->controller;
            }

            if ($parentId->parentId == 0) {
                break;
            }
        }

        $retVal = array_reverse($retVal);

        return $retVal;
    }
}

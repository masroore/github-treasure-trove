<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/4/20
 * Time: 9:34.
 */

namespace App\Http\Controllers;

use App\Models\Menu;

use DateTime;

class Util extends Controller
{
    // 2017-04-10 -> 2017/04/10
    public static function convertDate($date)
    {
        if (strlen($date) > 10) {
            $date = substr($date, 0, 10);
        }
        $createDate = str_replace('-', '/', $date);

        return $createDate;
    }

    public static function convertDateStr($dateStr)
    {
        $compDate = DateTime::createFromFormat('Y-m-d H:i:s', $dateStr);
        $returnStr = date_format($compDate, 'Y年m月d日 H点i分');

        return $returnStr;
    }

    public static function makeUploadFileName()
    {
        $datetime = date('YmdHis');
        $datetime = $datetime . mt_rand(1111, 9999);

        return $datetime;
    }

    public static function getMenuInfo($request): void
    {
        $path = $request->path();
        $menu = Menu::where('controller', $path)->first();
        $parentId = $menu['parentId'];
        $menuId = $menu['id'];

        if ($parentId < 10) {
            $GLOBALS['selMenu'] = $menuId;
            $GLOBALS['submenu'] = 0;
        } else {
            $GLOBALS['selMenu'] = $parentId;
            $GLOBALS['submenu'] = $menuId;
        }

    }
}

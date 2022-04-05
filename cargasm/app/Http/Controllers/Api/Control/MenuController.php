<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * @api {get} /api/v1/control/menus 01. Список всех меню
     * @apiVersion 1.0.0
     * @apiName GetMenuIndex
     * @apiGroup 31.Меню
     */
    public function index(Request $request)
    {
        return response([
            'data' => Menu::all(),
        ]);
    }
}

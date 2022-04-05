<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuWithItemsResource;
use App\Models\Menu;

class MenuController extends Controller
{
    /**
     * @api {get} /api/v1/menus/list 02. Список всех меню и ссылок
     * @apiVersion 1.0.0
     * @apiName GetMenuIndex
     * @apiGroup 18.Меню
     */
    public function list()
    {
        $menus = Menu::with(['items' => function ($q): void {
            $q->byLang();
        }])->get();

        //return MenuWithItemsResource::collection($menus);

        return response()->json([
            'data' => $menus->mapWithKeys(function ($item) {
                return [$item->slug => MenuWithItemsResource::make($item)];
            }),
        ]);
    }
}

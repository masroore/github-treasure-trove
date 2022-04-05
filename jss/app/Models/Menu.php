<?php
/**
 * Created by PhpStorm.
 * User: Cmb
 * Date: 2017/4/10
 * Time: 10:00.
 */

namespace App\Models;

use Auth;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'tb_menu';

    public static function getSubTitleAndController($menu, $userId): void
    {
    }

    public function userMenus()
    {
        return $this->hasOne('App\Users');
    }

    public function getMenuList()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userMenuList = $user->menu;
            $userMenuList = explode(',', $userMenuList);
            if (count($userMenuList) > 0 && $user->menu != '') {
                $idList = [];
                $parentIds = [];
                foreach ($userMenuList as $item) {
                    $parentIds[] = $item;
                }

                $records = self::whereIn('id', $parentIds)->get();

                $parentIds = [];
                foreach ($records as $key => $item) {
                    $ret = self::where('id', $item->id)->first();
                    $parentIds[] = $ret->parentId;
                    $child = self::where('parentId', $ret->id)->get();
                    foreach ($child as $kkk) {
                        $parentIds[] = $kkk->id;
                        $last = self::where('parentId', $kkk->id)->get();
                        foreach ($last as $yyy) {
                            $parentIds[] = $yyy->id;
                        }
                    }

                    $parentIds[] = $item->id;
                }

                $records = self::all();
                $datas = [];
                foreach ($records as $index => $record) {
                    if (in_array($record->id, $parentIds)) {
                        $datas[$record->parentId][] = $record;
                    }
                }

                $menus = [];
                foreach ($datas[0] as $index => $data) {
                    $menus[] = [
                        'id' => $data->id,
                        'title' => $data->title,
                        'parent' => $data->parentId,
                        'is_admin' => $data->admin,
                        'controller' => $data->controller,
                        'children' => [],
                        'ids' => [],
                    ];
                }
                foreach ($menus as $index => $menu) {
                    if (in_array($menu['id'], $parentIds)) {
                        $ret = $this->generateMenu($menu['id'], $menu, $datas);

                        $ids = [];
                        $ret = $this->getChildrenIds($menu['id'], $ids, $datas);
                        $menus[$index] = $menu;
                        $tmp = [];
                        foreach ($ids as $key => $item) {
                            foreach ($item as $value) {
                                $tmp[] = is_array($value) ? $value[0] : $value;
                            }
                        }

                        $tmp[] = $menu['id'];
                        $menus[$index]['ids'] += $tmp;
                    }
                }
            } else {
                return [];
            }
        } else {
            return [];
        }

        return $menus;
    }

    public function generateMenu($parent, &$menus, $datas)
    {
        if (!isset($datas[$parent])) {
            return 1;
        }

        foreach ($datas[$parent] as $index => $data) {
            $child = [
                'id' => $data->id,
                'title' => $data->title,
                'parent' => $data->parentId,
                'is_admin' => $data->admin,
                'controller' => $data->controller,
                'children' => [],
            ];

            $ret = $this->generateMenu($data->id, $child, $datas);
            $menus['children'][] = $child;
        }

        return 1;
    }

    public function getChildrenIds($parent, &$ids, $datas)
    {
        if (!isset($datas[$parent])) {
            return 1;
        }

        foreach ($datas[$parent] as $index => $data) {
            $child = [$data->id];

            $ret = $this->getChildrenIds($data->id, $child, $datas);
            $ids[] = $child;
        }

        return 1;
    }

    public function getRoute()
    {
        return $request->url();
    }
}

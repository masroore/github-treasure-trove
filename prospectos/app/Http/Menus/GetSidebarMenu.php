<?php
/*
*   07.11.2019
*   MenusMenu.php
*/

namespace App\Http\Menus;

use App\MenuBuilder\MenuBuilder;
use App\MenuBuilder\RenderFromDatabaseData;
use App\Models\Menus;

class GetSidebarMenu implements MenuInterface
{
    private $mb; //menu builder

    private $menu;

    public function __construct()
    {
        $this->mb = new MenuBuilder();
    }

    private function getMenuFromDB($menuId, $menuName): void
    {
        $this->menu = Menus::join('menu_role', 'menus.id', '=', 'menu_role.menus_id')
            ->select('menus.*')
            ->where('menus.menu_id', '=', $menuId)
            ->where('menu_role.role_name', '=', $menuName)
            ->orderBy('menus.sequence', 'asc')->get();
    }

    private function getGuestMenu($menuId): void
    {
        $this->getMenuFromDB($menuId, 'guest');
    }

    private function getUserMenu($menuId): void
    {
        $this->getMenuFromDB($menuId, 'user');
    }

    private function getAdminMenu($menuId): void
    {
        $this->getMenuFromDB($menuId, 'admin');
    }

    public function get($role, $menuId = 2)
    {
        $this->getMenuFromDB($menuId, $role);
        $rfd = new RenderFromDatabaseData();

        return $rfd->render($this->menu);
        /*
        $roles = explode(',', $roles);
        if(empty($roles)){
            $this->getGuestMenu( $menuId );
        }elseif(in_array('admin', $roles)){
            $this->getAdminMenu( $menuId );
        }elseif(in_array('user', $roles)){
            $this->getUserMenu( $menuId );
        }else{
            $this->getGuestMenu( $menuId );
        }
        $rfd = new RenderFromDatabaseData;
        return $rfd->render($this->menu);
        */
    }

    public function getAll($menuId = 2)
    {
        $this->menu = Menus::select('menus.*')
            ->where('menus.menu_id', '=', $menuId)
            ->orderBy('menus.sequence', 'asc')->get();
        $rfd = new RenderFromDatabaseData();

        return $rfd->render($this->menu);
    }
}

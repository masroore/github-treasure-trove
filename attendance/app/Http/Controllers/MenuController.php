<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Menupermission;
use App\SubMenu;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class MenuController extends Controller
{
    public function add_menu()
    {
        $data = Menu::orderBy('order', 'desc')->get();

        return view('Menu.add-menu', ['data' => $data]);
    }

    public function save_menu(Request $request)
    {
        $this->validate($request, [
            'menu' => 'required',
            'menuorder' => 'required',
        ]);

        if ($request->has('hiddenid')) {
            $id = $request->input('hiddenid');

            $data = Menu::findorfail($id)->update(['title' => $request->input('menu'), 'order' => $request->input('menuorder')]);

            toastr()->success('Menu Updated Successfully!');

            return Redirect()->route('add-menu');
        }

        $new = new Menu(['title' => $request->input('menu'), 'order' => $request->input('menuorder')]);
        $new->save();

        toastr()->success('Menu Added Successfully!');

        return Redirect()->back();
    }

    public function edit_menu($id)
    {
        $data = Menu::findorfail($id);

        return view('Menu.edit-menu', ['data' => $data]);
    }

    public function arrange_menu()
    {
        $data = Menu::orderBy('order', 'asc')->get();

        //dd($data);

        return view('Menu.arrange-menu', ['data' => $data]);
    }

    public function arrange_menu_save(Request $request)
    {
        $ids = $request->input('hiddenid');
        $order = $request->input('order');

        $countid = \count($ids);

        for ($i = 0; $i < $countid; $i++) {
            $update = ['order' => $order[$i]];
            Menu::where('id', $ids[$i])->update($update);
        }

        toastr()->success('Menu Arranged Successfully!');

        return Redirect()->route('add-menu');
    }

    public function arrange_submenu($id)
    {
        $data = Menu::orderBy('order', 'asc')
            ->where('id', $id)->first();

        return view('Menu.arrange-submenu', ['data' => $data]);
    }

    public function arrange_submenu_save(Request $request)
    {
        $ids = $request->input('hiddenid');
        $order = $request->input('order');

        $countid = \count($ids);

        for ($i = 0; $i < $countid; $i++) {
            $update = ['order' => $order[$i]];
            SubMenu::where('id', $ids[$i])->update($update);
        }

        toastr()->success('Sub Menu Arranged Successfully!');

        return Redirect()->route('add-permission');
    }

    public function delete_menu($id)
    {
        $data = Menu::findorfail($id)->delete();

        toastr()->success('Menu Deleted Successfully!');

        return Redirect()->back();
    }

    //permission

    public function add_permission()
    {
        $data = Menu::orderBy('order', 'asc')->get();

        return view('Menu.add-permission', ['data' => $data]);
    }

    public function save_permission(Request $request)
    {
        $this->validate($request, [
      'menu' => 'required',
  ]);

        $menuid = $request->input('menu');

        $menuti = Menu::where('id', $menuid)->first();

        $submenu = $request->input('submenu');
        $suborder = $request->input('menuorder');

        $count = \count($submenu);

        for ($i = 0; $i < $count; $i++) {
            $viewtitle = 'view ' . $submenu[$i];
            $createtitle = 'create ' . $submenu[$i];
            $edittitle = 'edit ' . $submenu[$i];
            $deletetitle = 'delete ' . $submenu[$i];

            $adddtosub = new SubMenu(
                ['menu_id'=> $menuid, 'sub_menu'=> $submenu[$i], 'order' => $suborder[$i]]
            );

            $adddtosub->save();

            //add to permission
            $subid = $adddtosub->id;

            $first = 'view ' . $menuti->title;

            $check = Permission::where('name', $first)->first();
            if (!$check) {
                $firstper = Permission::create(['name' => $first]);
                //insert to database
                $fadddtomenu = new Menupermission(
                    ['sub_menu_id'=> $subid, 'menu_id'=> $menuid, 'permission_id'=> $firstper->id]
                );
                $fadddtomenu->save();
            }

            $checksen = Permission::where('name', $viewtitle)->first();
            if (!$checksen) {
                $second = Permission::create(['name' => $viewtitle]);
                $sadddtomenu = new Menupermission(
                    ['sub_menu_id'=> $subid, 'menu_id'=> $menuid, 'permission_id'=> $second->id]
                );
                $sadddtomenu->save();
            }

            $checkthird = Permission::where('name', $createtitle)->first();
            if (!$checkthird) {
                $third = Permission::create(['name' => $createtitle]);
                $tadddtomenu = new Menupermission(
                    ['sub_menu_id'=> $subid, 'menu_id'=> $menuid, 'permission_id'=> $third->id]
                );
                $tadddtomenu->save();
            }

            $checkforth = Permission::where('name', $edittitle)->first();
            if (!$checkforth) {
                $forth = Permission::create(['name' => $edittitle]);
                $fiadddtomenu = new Menupermission(
                    ['sub_menu_id'=> $subid, 'menu_id'=> $menuid, 'permission_id'=> $forth->id]
                );
                $fiadddtomenu->save();
            }

            $checkfifth = Permission::where('name', $deletetitle)->first();
            if (!$checkfifth) {
                $fifth = Permission::create(['name' => $deletetitle]);
                $fifadddtomenu = new Menupermission(
                    ['sub_menu_id'=> $subid, 'menu_id'=> $menuid, 'permission_id'=> $fifth->id]
                );
                $fifadddtomenu->save();
            }
        }

        toastr()->success('Menu Permissions Added Successfully!');

        return Redirect()->back();
    }

    public function save_permission_role(Request $request)
    {
        dd($request);
    }

    public function edit_permission($id)
    {
        $submenu = SubMenu::where('id', $id)->first();

        $menuper = Menupermission::where('sub_menu_id', $id)->get();

        foreach ($menuper as $row) {
            $perid = $row->permission_id;
            $id = $row->id;
            $delmenuper = Menupermission::where('id', $id)->first();

            $permissdelete = Permission::where('id', $perid)->first();

            $delmenuper->delete();
            $permissdelete->delete();
        }

        $submenu->delete();

        toastr()->success('Menu Permissions Deleted Successfully!');

        return Redirect()->back();
    }
}

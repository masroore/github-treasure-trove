<?php

namespace App\Http\Controllers;

use App\Models\Member\Post;
use App\Models\Member\Unit;
use App\Models\Menu;
use App\Models\ShipManage\ShipRegister;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Session;

class ProfileController extends Controller
{
    public function index()
    {
        $userInfo = Auth::user();
        $units = Unit::unitFullNameList();
        $posts = Post::orderBy('orderNum')->get();
        $pmenus = Menu::where('parentId', '=', 0)->get();
        $cmenus = [];
        $index = 0;

        $state = Session::get('state');

        foreach ($pmenus as $pmenu) {
            $cmenus[$index] = [];
            $cmenus[$index] = Menu::where('parentId', $pmenu['id'])->orderBy('id')->get();
            ++$index;
        }

        $userid = $userInfo->id;
        $userinfo = User::find($userid);
        $shipList = ShipRegister::orderByRaw("FIELD(RegStatus , '2', '1', '3') ASC")->orderBy('id')->get();

        return view('profile.index', [
            'userid' => $userid,
            'userinfo' => $userinfo,
            'units' => $units,
            'pos' => $posts,
            'pmenus' => $pmenus,
            'cmenus' => $cmenus,
            'state' => $state,
            'shipList' => $shipList,

            'breadList' => [[
                '', '编辑信息', ],
            ],
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $params = $request->all();
        $password = '';
        if (isset($params['password']) && $params['password'] != '') {
            $request->validate([
                'oldpassword' => 'required',
                'password' => 'min:6|confirmed',
            ]);
        }
        if (isset($params['oldpassword']) && $params['oldpassword'] != '') {
            $request->validate([
                'password' => 'required|min:6|confirmed',
            ]);
            if (isset($params['password']) && $params['password'] != '') {
                $request->validate([
                    'oldpassword' => 'required',
                    'password' => 'min:6|confirmed',
                ]);

                $hashedPassword = Auth::user()->password;

                if (Hash::check($request->oldpassword, $hashedPassword)) {
                    if (!Hash::check($request->password, $hashedPassword)) {
                        $password = bcrypt($params['password']);
                    } else {
                        session()->flash('err_msg', '新密码不能成为旧密码。');

                        return redirect()->back();
                    }
                } else {
                    session()->flash('err_msg', '旧密码不一致。');

                    return redirect()->back();
                }
            }
        }

        $account = Auth::user()->account;
        $avatar_url = '';
        if ($request->file('avatar')) {
            $file = $request->file('avatar');
            $fileName = $account;
            $name = $fileName . '.' . $file->extension();
            $file->move(public_path() . '/avatar/', $name);
            $avatar_url = '/avatar/' . $name;
        }

        $userTbl = User::find($params['id']);

        $userTbl['realname'] = $params['name'];
        $userTbl['phone'] = $params['phone'];
        if ($avatar_url != '') {
            $userTbl['avatar'] = $avatar_url;
        }

        if ($password != '') {
            $userTbl['password'] = $password;
        }

        $userTbl['remark'] = $params['remark'] ?? '';

        $userTbl->save();

        return redirect('/profile')->with(['message' => trans('common.message.update.success')]);
    }
}

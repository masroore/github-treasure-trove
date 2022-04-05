<?php

namespace App\Http\Controllers\Orgmanage;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Util;
use App\Models\BreadCrumb;
use App\Models\Decision\DecisionReport;
use App\Models\Home\Settings;
use App\Models\Home\SettingsSites;
use App\Models\Member\Career;
use App\Models\Member\Post;
use App\Models\Member\Unit;
use App\Models\Menu;
use App\Models\Operations\VoyLog;
use App\Models\ShipManage\ShipRegister;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class OrgmanageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function unitManage(Request $request)
    {
        Util::getMenuInfo($request);

        $units = Unit::unitList();

        return view('orgmanage.quartermanage', ['units' => $units]);
    }

    public function unitDelete(Request $request)
    {
        $unitId = $request->get('unitId');

        $unit = Unit::find($unitId);
        if (null === $unit) {
            return;
        }

        $unitKey = $unit['orderkey'];

        $unitIds = Unit::select(DB::raw('GROUP_CONCAT(id) as unitIds'))->where('orderkey', 'like', $unitKey . '%')->first();
        if (isset($unitIds)) {
            $idList = explode(',', $unitIds['unitIds']);
            UserInfo::whereIn('unit', $idList)->update(['unit' => 0]);
        }
        Unit::where('orderkey', 'like', $unitKey . '%')->delete();

        return 'success';
    }

    public function unitUpdate(Request $request)
    {
        $unitId = $request->get('unitId');
        $unitName = $request->get('unitName');

        $isExist = Unit::where('title', $unitName)->first();
        if (isset($isExist) && ($unitId != $isExist['id'])) {
            return 'overlay';
        }

        $unit = Unit::find($unitId);
        if (null === $unit) {
            return;
        }

        $unit['title'] = $unitName;
        $unit->save();

        return 'success';
    }

    public function unitRegister(Request $request)
    {
        $parentId = $request->get('parentId');
        $name = $request->get('unitName');

        $isExist = Unit::where('title', $name)->first();

        if ($isExist) {
            return;
        }

        $last = Unit::where('parentId', $parentId)->orderBy('orderkey', 'desc')->first();

        if (null === $last) {
            $parent = Unit::find($parentId);
            $newKey = $parent['orderkey'] . $this->int2keystr(1);
        } else {
            $lastKey = $last['orderkey'];
            $len = strlen($lastKey);
            $subkey = substr($lastKey, $len - 3) * 1;
            $parentKey = substr($lastKey, 0, $len - 3);
            $newKey = $parentKey . $this->int2keystr($subkey + 1);
        }

        $unit = new Unit();
        $unit['title'] = $name;
        $unit['parentId'] = $parentId;
        $unit['orderkey'] = $newKey;
        $unit->save();

        return 'success';
    }

    public function int2keystr($num)
    {
        return sprintf('%03d', $num);
    }

    public function keystr2int($str)
    {
        return number_format($str);
    }

    public function savepost(Request $request)
    {
        $orderNum = $request->get('orderNum');
        $postname = $request->get('postname');
        $post = new Post();
        $post->orderNum = $orderNum;
        $post->title = $postname;
        $post->save();
        $result = ['result' => 'success'];

        return json_encode($result);
    }

    public function showpostmanage(Request $request)
    {
        $GLOBALS['selMenu'] = $request->get('menuId');
        $GLOBALS['submenu'] = 0;

        $posts = Post::orderBy('orderNum')->get();
        $maxLevel = Post::all()->max('orderNum') + 1;

        return view('orgmanage.postmanage', ['posts' => $posts, 'maxLevel' => $maxLevel]);
    }

    public function updatepost(Request $request)
    {
        $post = Post::find($request->id);
        $post->orderNum = $request->orderNum;
        $post->title = $request->title;
        $this->validate($request, [
            'orderNum' => 'required|max:255',
            'title' => 'required',
        ]);
        $post->save();
        $result = ['result' => 'success'];

        return json_encode($result);
    }

    public function delpost(Request $request)
    {
        $post = Post::find($request->id);
        $post->delete();
        $result = ['result' => 'success'];

        return json_encode($result);
    }

    public function addpost(Request $request)
    {
        $this->validate($request, [
            'orderNum' => 'required|max:255',
            'title' => 'required',
        ]);
        $post = new Post();
        $post->orderNum = $request->orderNum;
        $post->title = $request->title;
        $post->save();
        $result = ['result' => 'success'];

        return json_encode($result);
    }

    public function updateSettings(Request $request)
    {
        $graph_year = $request->get('select-graph-year');
        $graph_ship = json_encode($request->get('select-graph-ship'));
        $cert_expire_date = $request->get('cert-expire_date');
        $report_year = $request->get('select-report-year');
        $dyn_year = $request->get('select-dyn-year');
        $port_year = $request->get('select-port-year');
        $settings = new Settings();
        //$settings::first()->update(['graph_year'=> $graph_year,'graph_ship'=>$graph_ship,'cert_expire_date'=>$cert_expire_date,'report_year'=>$report_year,'dyn_year'=>$dyn_year]);
        Settings::where('id', 1)->update(['graph_year' => $graph_year, 'graph_ship' => $graph_ship, 'cert_expire_date' => $cert_expire_date, 'report_year' => $report_year, 'dyn_year' => $dyn_year, 'port_year' => $port_year]);

        $report_ids = $request->get('visible_id');
        $report_values = $request->get('visible_value');
        if (isset($report_ids) && count($report_ids) > 0) {
            foreach ($report_ids as $index => $id) {
                DecisionReport::where('report_id', $id)->update(['ishide' => $report_values[$index]]);
            }
        }

        $dyn_ids = $request->get('dyn_id');
        $dyn_values = $request->get('dyn_value');
        if (isset($dyn_ids) && count($dyn_ids) > 0) {
            foreach ($dyn_ids as $index => $id) {
                VoyLog::where('id', $id)->update(['ishide' => $dyn_values[$index]]);
            }
        }

        $site_orders = $request->get('site_orders');
        $site_links = $request->get('site_links');
        $site_updates = $request->get('is_update');
        $site_attachments = $request->file('attachment');
        $site_image = $request->get('image');
        $site_image_path = $request->get('image_path');

        $file_index = 0;
        SettingsSites::truncate();
        for ($index = 0; $index < count($site_links); ++$index) {
            $siteTbl = new SettingsSites();
            $siteTbl['link'] = $site_links[$index];
            $siteTbl['orderNo'] = $site_orders[$index];
            $siteTbl['image'] = $site_image[$index];
            $siteTbl['image_path'] = $site_image_path[$index];
            if ($site_updates[$index] == '1') {
                if ($site_attachments[$index] != null) {
                    $file = $site_attachments[$index];
                    ++$file_index;
                    $fileName = $file->getClientOriginalName();
                    $name = date('Ymd_His') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . '/shipCertList/', $name);
                    $siteTbl['image'] = '/shipCertList/' . $name;
                    $siteTbl['image_path'] = public_path('/shipCertList/') . $name;
                }
            }
            $siteTbl->save();
        }
        /*
        for ($index=0;$index<count($site_links);$index++) {
            $siteTbl = SettingsSites::find($index+1);
            //$siteTbl = new SettingsSites();
            $siteTbl['link'] = $site_links[$index];
            $siteTbl['orderNo'] = $site_orders[$index];

            if($site_updates[$index] == '1') {
                if ($site_attachments[$index] != null) {
                    $file = $site_attachments[$index];
                    $file_index++;
                    $fileName = $file->getClientOriginalName();
                    $name = date('Ymd_His') . '_' . Str::random(10). '.' . $file->getClientOriginalExtension();
                    $file->move(public_path() . '/shipCertList/', $name);
                    $siteTbl['image'] = '/shipCertList/' . $name;
                    $siteTbl['image_path'] = public_path('/shipCertList/') . $name;
                }
                else {
                    if (file_exists($siteTbl['image_path'])) {
                        @unlink($siteTbl['image_path']);
                    }
                    $siteTbl['image'] = null;
                    $siteTbl['image_path'] = null;
                }
            }
            $siteTbl->save();
        }
        */

        /*
        foreach($site_orders as $index => $orders) {
            if ($sites_updates[$index] == '1') {
                $file = $site_attachments[$index];
                $fileName = $file->getClientOriginalName();
                $name = date('Ymd_His') . '_' . Str::random(10). '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . '/shipCertList/', $name);
                if($shipCertTbl['attachment'] != '' && $shipCertTbl['attachment'] != null) {
                    if(file_exists($shipCertTbl['attachment']))
                        @unlink($shipCertTbl['attachment']);
                }

                $shipCertTbl['attachment'] = public_path('/shipCertList/') . $name;
                $shipCertTbl['attachment_link'] = url('/') . '/shipCertList/' . $name;
                $shipCertTbl['file_name'] = $fileName;
            }
        }
        */
        return redirect('org/system/settings');
    }

    public function userInfoListView(Request $request)
    {
        $url = $request->path();
        $breadCrumb = BreadCrumb::getBreadCrumb($url);

        $unitId = $request->get('unit');
        $pos = $request->get('pos');
        $realname = $request->get('realname');
        $status = $request->get('status');

        $unitList = Unit::all(['id', 'title']);
        $posList = Post::all(['id', 'title']);

        $userlist = User::where('status', STATUS_ACTIVE)->where('is_show', '!=', STAFF_LEVEL_MANAGER)->orderBy('pos', 'asc')->get();

        return view(
            'orgmanage.memberinfo',
            ['list' => $userlist,
                'unitList' => $unitList,
                'posList' => $posList,
                'realname' => $realname,
                'unitId' => $unitId,
                'posId' => $pos,
                'status' => $status,
                'type' => 'edit',
                'realname' => $realname,

                'breadCrumb' => $breadCrumb,
            ]
        );
    }

    // Go to Personal Info Edit screen
    public function updateMemberinfo(Request $request)
    {
        $userid = $request->get('userId');

        $userinfo = UserInfo::find($userid);
        $user = User::find($userid);

        return view('org/memberadd', ['profile' => $userinfo, 'user' => $user]);
    }

    public function addMemberinfo(Request $request)
    {
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

        $userid = $request->get('uid');
        if (empty($userid)) {
            if (isset($state) && ($state == 'success')) {
                $userid = Session::get('userId');
            }
        }

        $userinfo = User::find($userid);
        $shipList = ShipRegister::where('RegStatus', '!=', 3)->orderBy('id')->get();

        return view(
            'orgmanage.addmember',
            ['userid' => $userid,
                'userinfo' => $userinfo,
                'units' => $units,
                'pos' => $posts,
                'pmenus' => $pmenus,
                'cmenus' => $cmenus,
                'state' => $state,
                'shipList' => $shipList,

                'breadList' => [
                    ['/org/system/settings', '行政管理'],
                    ['/org/userInfoListView', '职员信息'],
                    ['', (empty($userid) ? '添加' : '修改')],
                ],
            ]
        );
    }

    /*
    public function checkShipPrivilege($param) {
        return redirect()->back()->with(['state'=>'BBBBB', 'userId'=>'']);

        if(isset($param['shipList'])) {
            $shipList = $param['shipList'];
            $ship_count = count($shipList);
            if($param['pos'] == STAFF_LEVEL_SHAREHOLDER || $param['pos'] == STAFF_LEVEL_CAPTAIN)
            {
                if ($ship_count == 0) {
                    return redirect()->back()->with(['state'=>'请选择船舶。', 'userId'=>'']);
                } else if($ship_count > 1) {
                    return redirect()->back()->with(['state'=>'只能选择一条船。', 'userId'=>'']);
                }
            }
        } else {
            if($param['pos'] == STAFF_LEVEL_SHAREHOLDER || $param['pos'] == STAFF_LEVEL_CAPTAIN)
            {
                return redirect()->back()->with(['state'=>'请选择船舶。', 'userId'=>'']);
            }
        }
    }
    */

    public function updateMember(Request $request)
    {
        $param = $request->all();
        if (isset($param['shipList'])) {
            $shipList = $param['shipList'];
            $ship_count = count($shipList);
            if ($param['pos'] == STAFF_LEVEL_SHAREHOLDER || $param['pos'] == STAFF_LEVEL_CAPTAIN) {
                if ($ship_count == 0) {
                    return redirect()->back()->with(['state' => '请选择船舶。', 'userId' => '']);
                } elseif ($ship_count > 1) {
                    return redirect()->back()->with(['state' => '只能选择一条船。', 'userId' => '']);
                }
            }
        } else {
            if ($param['pos'] == STAFF_LEVEL_SHAREHOLDER || $param['pos'] == STAFF_LEVEL_CAPTAIN) {
                return redirect()->back()->with(['state' => '请选择船舶。', 'userId' => '']);
            }
        }
        $file = $request->file('photopath');
        if (isset($file)) {
            $ext = $file->getClientOriginalExtension();
            $filename = Util::makeUploadFileName() . '.' . $ext;
            $file->move(public_path('uploads/logo'), $filename);
        } else {
            $filename = null;
        }

        $userid = $request->get('userid');
        $param = $request->all();

        $user = User::find($userid);
        $user->account = $param['account'];
        $user->realname = $param['name'];
        $user->phone = $param['phone'];
        $user->remark = $param['remark'] ?? '';
        $user->pos = $param['pos'];

        $user->entryDate = $param['enterdate'] == '' ? null : $param['enterdate'];
        $releaseDate = $param['releaseDate'];
        if (!empty($param['enterdate'])) {
            $user->entryDate = $param['enterdate'];
        }

        if (!empty($param['releaseDate'])) {
            $user->releaseDate = $param['releaseDate'];
            $user->status = STATUS_BANNED;
        } else {
            $user->status = STATUS_ACTIVE;
        }

        // $user->isAdmin = (isset($param['isAdmin']) && $param['isAdmin'] == 1) ? 1 : ($param['pos'] == STAFF_LEVEL_SHAREHOLDER ? STAFF_LEVEL_SHAREHOLDER : 0);

        if ($param['pos'] == STAFF_LEVEL_MANAGER) {
            $user->isAdmin = STAFF_LEVEL_MANAGER;
        } else {
            $user->isAdmin = STATUS_BANNED;
        }

        if (isset($param['password_reset']) && $param['password_reset'] == true) {
            $user->password = bcrypt(DEFAULT_PASS);
        }

        $this->storePrivilege($request, false);
        $user->save();

        return redirect('org/memberadd?uid=' . $user->id);
    }

    public function addMember(Request $request)
    {
        $param = $request->all();
        if (isset($param['shipList'])) {
            $shipList = $param['shipList'];
            $ship_count = count($shipList);
            if ($param['pos'] == STAFF_LEVEL_SHAREHOLDER || $param['pos'] == STAFF_LEVEL_CAPTAIN) {
                if ($ship_count == 0) {
                    return redirect()->back()->with(['state' => '请选择船舶。', 'userId' => '']);
                } elseif ($ship_count > 1) {
                    return redirect()->back()->with(['state' => '只能选择一条船。', 'userId' => '']);
                }
            }
        } else {
            if ($param['pos'] == STAFF_LEVEL_SHAREHOLDER || $param['pos'] == STAFF_LEVEL_CAPTAIN) {
                return redirect()->back()->with(['state' => '请选择船舶。', 'userId' => '']);
            }
        }
        $file = $request->file('photopath');

        if (isset($file)) {
            $ext = $file->getClientOriginalExtension();
            $filename = Util::makeUploadFileName() . '.' . $ext;
            $file->move(public_path('uploads/logo'), $filename);
        } else {
            $filename = null;
        }

        $request->validate([
            'account' => 'required|unique:tb_users',
        ]);

        $user = new User();
        $user->account = $param['account'];
        $user->realname = $param['name'];
        $user->password = bcrypt(DEFAULT_PASS);
        $user->pos = $param['pos'];
        $user->phone = $param['phone'];
        $user->remark = $param['remark'] ?? '';
        if (!empty($param['enterdate'])) {
            $user->entryDate = $param['enterdate'];
        }

        if (!empty($param['releaseDate'])) {
            $user->releaseDate = $param['releaseDate'];
            $user->status = STATUS_BANNED;
        } else {
            $user->status = STATUS_ACTIVE;
        }

        if ($param['pos'] == STAFF_LEVEL_MANAGER) {
            $user->isAdmin = STAFF_LEVEL_MANAGER;
        } else {
            $user->isAdmin = STATUS_BANNED;
        }

        $user->save();
        $request->merge([
            'userid' => $user->id,
        ]);

        $this->storePrivilege($request, true);

        return redirect('org/memberadd?uid=' . $user->id);
    }

    public function upload(Request $request)
    {
        $file = $request->files('photo');
        $desdir = '/upload';
        $desfilename = 'tmp';
        $file->move($desdir, $file->getClientOriginalName());
        $photo = $request->get('photo');
        $data = ['result' => 'success'];

        return json_encode($data);
    }

    public function deleteMember(Request $request)
    {
        $params = $request->all();
        $userid = $params['userid'];
        $ret = User::where('id', $userid)->delete();
        //$ret = Career::where('userId', $userid)->delete();
        //$ret = UserInfo::where('id', $userid)->delete();

        return response()->json($ret);
    }

    public function userPrivilege(Request $request)
    {
        Util::getMenuInfo($request);

        $unitId = $request->get('unit');
        $pos = $request->get('pos');
        $realname = $request->get('realname');
        $status = $request->get('status');

        $unitList = Unit::all(['id', 'title']);
        $posList = Post::all(['id', 'title']);

        $userlist = User::getSimpleUserList($unitId, $pos, $realname, $status);

        if (isset($unitId)) {
            $userlist->appends(['unit' => $unitId]);
        }
        if (isset($pos)) {
            $userlist->appends(['pos' => $pos]);
        }
        if (isset($realname)) {
            $userlist->appends(['realname' => $realname]);
        }

        return view(
            'orgmanage.memberinfo_privilege',
            ['list' => $userlist,
                'unitList' => $unitList,
                'posList' => $posList,
                'realname' => $realname,
                'unitId' => $unitId,
                'posId' => $pos,
                'status' => $status,
                'realname' => $realname,
            ]
        );
    }

    public function addPrivilege(Request $request)
    {
        $units = Unit::unitFullNameList();
        $posts = Post::orderBy('orderNum')->orderByRaw('CAST(OrderNum AS SIGNED) ASC')->get();
        $pmenus = Menu::where('parentId', '=', 0)->get();
        $cmenus = [];
        $index = 0;

        foreach ($pmenus as $pmenu) {
            $cmenus[$index] = [];
            $cmenus[$index] = Menu::where('parentId', $pmenu['id'])->orderBy('id')->get();
            ++$index;
        }

        $state = Session::get('state');

        $userid = $request->get('uid');
        if (empty($userid)) {
            if (isset($state) && ($state == 'success')) {
                $userid = Session::get('userId');
            }
        }

        $userinfo = User::find($userid);
        $shipList = ShipRegister::getShipListByOrigin();

        return view(
            'orgmanage.privilege_manage',
            ['userid' => $userid,
                'userinfo' => $userinfo,
                'shipList' => $shipList,
                'units' => $units,
                'pos' => $posts,
                'pmenus' => $pmenus,
                'cmenus' => $cmenus,
                'state' => $state,
            ]
        );
    }

    // Store privilege status
    public function storePrivilege(Request $request, $isAdd)
    {
        $param = $request->all();
        $userid = $param['userid'];
        $pos = $param['pos'];

        if (User::find($userid) == null) {
            return back()->with([
                'state' => '不存在的用户。',
                'userId' => $userid,
            ]);
        }

        $menus = Menu::all();
        // Privilege Check List
        $allowmenus = '';

        if ($isAdd) {
            if ($pos == STAFF_LEVEL_SHAREHOLDER) {
                $allowmenus = 3;
            }
            /*
            else if ($pos == STAFF_LEVEL_OPERATOR) {
                $allowmenus = '2,3,5,26,28';
            }
            else if ($pos == STAFF_LEVEL_ENGINEER) {
                $allowmenus = '2,3,4,5';
            }
            else if ($pos == STAFF_LEVEL_SEAMAN) {
                $allowmenus = '2,3,6';
            }
            else if ($pos == STAFF_LEVEL_FINANCIAL) {
                $allowmenus = '2,3,7,38';
            }
            else if ($pos == STAFF_LEVEL_OTHER) {
                $allowmenus = '2,3,4,5,6,7,8,10';
            }
            else if ($pos == STAFF_LEVEL_CAPTAIN) {
                $allowmenus = '3';
            }
            */
            else {
                foreach ($menus as $menu) {
                    if (isset($param[$menu['id']])) {
                        $allowmenus = empty($allowmenus) ? $menu['id'] : $allowmenus . ',' . $menu['id'];
                    }
                }
            }
        } else {
            if ($pos == STAFF_LEVEL_SHAREHOLDER) {
                $allowmenus = 3;
            } else {
                foreach ($menus as $menu) {
                    if (isset($param[$menu['id']])) {
                        $allowmenus = empty($allowmenus) ? $menu['id'] : $allowmenus . ',' . $menu['id'];
                    }
                }
            }
        }

        $insertData = [];
        $insertData = ['menu' => $allowmenus];

        if (isset($param['shipList'])) {
            $shipList = $param['shipList'];
            $shipListInfo = '';
            foreach ($shipList as $item) {
                $shipListInfo .= $item . ',';
            }

            $shipListInfo = substr($shipListInfo, 0, strlen($shipListInfo) - 1);
            $insertData['shipList'] = $shipListInfo;
        } else {
            $insertData['shipList'] = '';
        }

        $user = new User();
        User::where('id', $userid)->update($insertData);

        return redirect()->back()->with(['state' => 'success', 'userId' => $userid]);
    }
}

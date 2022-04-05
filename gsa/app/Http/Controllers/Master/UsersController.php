<?php

namespace App\Http\Controllers\Master;

use App\Agen;
use App\Customer;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ((int) Auth::user()->page_user == 1) {
            return view('pages.master.users.index');
        }
        abort(403);
    }

    public function datatables()
    {
        $users = User::where('id', '>', '0')->orderBy('id', 'desc');

        return Datatables::of($users)
            ->addColumn('aksi', function ($a) {
            $status = 'nonaktif';
            if ($a['status'] == 'nonaktif') {
                $status = 'aktif';
            }

            return '
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="' . url('master/users/edit/' . $a['id']) . '" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" data-toggle="tooltip" data-placement="bottom" title="Tombol Edit Customer">
                    <i class="flaticon-edit-1"></i>
                </a>
                <button type="button" class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" data-toggle="tooltip" data-placement="bottom" title="Tombol Hapus Customer" onClick="deleteCustomer(\'' . $status . '\',' . $a['id'] . ',\'' . $a['nama'] . '\')"> <i class="flaticon-delete"></i> </button>
            </div>';
        })
            ->addColumn('jenis', function ($a) {
            $jenis = '<p><i class="fa fa-user-circle-o" aria-hidden="true"></i>&nbsp;admin</p>';
            if ($a['level'] == 2) {
                $jenis = '<p><i class="fa fa-address-card" aria-hidden="true"></i>&nbsp;Customer</p>';
            }
            if ($a['level'] == 3) {
                $jenis = '<p><i class="fa fa-users" aria-hidden="true"></i>&nbsp;Kantor Agen</p>';
            }
            if ($a['level'] == 4) {
                $jenis = '<p><i class="fa fa-motorcycle" aria-hidden="true"></i>&nbsp;Delivery Kurir</p>';
            }
            if ($a['level'] == 5) {
                $jenis = '<p><i class="fa fa-truck" aria-hidden="true"></i>&nbsp;Supir(driver)</p>';
            }

            return $jenis;
        })
            ->addColumn('aktifnonaktif', function ($a) {
            $aktifnonaktif = '<div class="text-center alert alert-success m-0 p-1" role="alert">AKTIF</div>';
            if ($a['status'] == 'nonaktif') {
                $aktifnonaktif = '<div class="alert alert-danger m-0 p-1 text-center" role="alert">NONAKTIF</div>';
            }

            return $aktifnonaktif;
        })
            ->addColumn('akseshalaman', function ($a) {
            $akseshalaman = '';
            if ((int) $a['page_customer'] == 1) {
                $akseshalaman = $akseshalaman . '<span class="badge badge-primary" style="margin:2px;">Master Customer</span>';
            }
            if ((int) $a['page_agen'] == 1) {
                $akseshalaman = $akseshalaman . '<span class="badge badge-primary" style="margin:2px;">Master Agen</span>';
            }
            if ((int) $a['page_user'] == 1) {
                $akseshalaman = $akseshalaman . '<span class="badge badge-primary" style="margin:2px;">Master User</span>';
            }

            return $akseshalaman;
        })
            ->rawColumns(['aksi', 'jenis', 'aktifnonaktif', 'akseshalaman'])
            ->make(true);
    }

    public function checkusername(Request $request)
    {
        $data['username'] = User::where('username', $request->username)->where('id', '>', 0)->get();

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    public function gantipassword(Request $request)
    {
        // echo $request->username;
        // echo $request->password;
        $users = User::where('username', $request['username'])->first();
        $users->password = Hash::make($request['password']);
        $users->save();

        return redirect('/')->with('message', 'Password Updated');
    }

    public function save(Request $request)
    {
        $users = new User();
        $users->nama = ($request->nama) ?: '';
        $users->email = ($request->email) ?: '';
        $users->notelp = ($request->notelp) ?: '';
        $users->alamat = ($request->alamat) ?: '';
        $users->level = ($request->level) ?: 0;
        $users->id_customer = ($request->id_customer) ?: 0;
        $users->id_agen = ($request->id_agen) ?: 0;
        $users->page_customer = ($request->page_customer == 'on') ? 1 : 0;
        $users->page_user = ($request->page_user == 'on') ? 1 : 0;
        $users->page_agen = ($request->page_agen == 'on') ? 1 : 0;
        $users->username = ($request->username) ? strtolower(preg_replace('/\s+/', '_', $request->username)) : '';
        $users->status = 'aktif';
        $users->password = '$2y$10$s.aYGxhPXfTPN3/Hf8i1t.UDIWZUFIOdxhUl6c56YcrF7kI0Y3g3W';
        $users->save();

        return redirect('master/users')->with('message', 'created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if ((int) Auth::user()->page_user == 1) {
            $data['users'] = User::find($id);
            $data['customer'] = Customer::get();
            $data['agen'] = Agen::get();
            // return view('pages.master.users.edit',compact('users'));

            // $data['action']='ubah';
            return view('pages.master.users.edit', $data);
        }
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $users = User::where('id', $request['id'])->first();
        $users->nama = ($request->nama) ?: '';
        $users->email = ($request->email) ?: '';
        $users->notelp = ($request->notelp) ?: '';
        $users->alamat = ($request->alamat) ?: '';
        $users->username = ($request->username) ?: '';
        $users->level = ($request->level) ?: 0;
        $users->id_customer = ($request->id_customer) ?: 0;
        $users->id_agen = ($request->id_agen) ?: 0;
        $users->page_customer = ($request->page_customer == 'on') ? 1 : 0;
        $users->page_user = ($request->page_user == 'on') ? 1 : 0;
        $users->page_agen = ($request->page_agen == 'on') ? 1 : 0;
        // dd($request);
        $users->save();

        return redirect('master/users')->with('message', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function delete(Request $request)
    {
        $user = User::where('id', $request['id'])->first();
        $user->status = $request['status'];
        $user->save();
        // User::find($request->id)->delete();
        // activity()->withProperties(['username yang terhapus' => $user2->username], "deleted_users")->log('deleted_users');
        return response()->json(['user' => $user]);
    }
}

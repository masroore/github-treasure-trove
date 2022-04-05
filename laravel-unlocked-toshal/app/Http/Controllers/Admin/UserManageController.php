<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use App\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class UserManageController extends Controller
{
    public function __construct()
    {
    }

    /*
    Method Name:    getList
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        To get list of all users
    Params:
    */
    public function getList(Request $request)
    {
        if ($request->has('search_keyword') && $request->search_keyword != '') {
            $keyword = $request->search_keyword;
        } else {
            $keyword = '';
        }
        $data = User::when($request->search_keyword, function ($q) use ($request): void {
            $q->where('first_name', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('last_name', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('email', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('status', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('id', $request->search_keyword);
        })->role('User')->sortable('id')->paginate(Config::get('constants.PAGINATION_NUMBER'));

        return view('admin.users.list', compact('data', 'keyword'));
    }
    // ->role('User')

    // End Method getList

    /*
    Method Name:    del_record
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        To delete any user by id
    Params:         [id]
    */
    public function del_record(Request $request)
    {
        try {
            $getData = $request->all();
            $bookings = Booking::where('user_id', $getData['id'])->first();
            if ($bookings) {
                $user = User::find($getData['id']);
                $user->is_deleted = $getData['is_deleted'];
                if ($getData['is_deleted'] == 0) {
                    $status = 'RECOVER_DONE';
                } else {
                    $status = 'DELETE_DONE';
                }
                $user->save();
            } else {
                User::find($getData['id'])->delete();
                $status = 'DELETE_DONE';
            }

            return redirect()->back()->with('status', 'success')->with('message', 'User ' . Config::get('constants.SUCCESS.' . $status));
        } catch (Exception $ex) {
            return redirect()->back()->with('status', 'error')->with('message', $ex->getMessage());
        }
    }
    // End Method del_record

    /*
    Method Name:    edit_form
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        Form to update user details
    Params:         [id]
    */
    public function edit_form($id)
    {
        $userDetail = User::role('User')->find($id);
        if (!$userDetail) {
            return redirect()->route('users.list');
        }
        $roles = Role::get();

        return view('admin.users.edit', compact('userDetail', 'roles'));
    }
    // End Method edit_record

    /*
    Method Name:    update_record
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        To update user details
    Params:         [edit_record_id, first_name, last_name, email, role, status]
    */
    public function update_record(Request $request)
    {
        $postData = $request->all();
        $id = $postData['edit_record_id'];
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'address' => '',
            'zipcode' => 'required|numeric',
            'mobile' => 'required|numeric',
            'status' => 'required',
        ]);

        try {
            $users = User::findOrFail($id);
            $userDetail = UserDetails::where('user_id', $id)->first();
            if (!$userDetail) {
                UserDetails::create(['user_id' => $id]);
            }

            $users->first_name = $postData['first_name'];
            $users->last_name = $postData['last_name'];
            $users->email = $postData['email'];
            $users->user_detail->address = $postData['address'];
            $users->user_detail->zipcode = $postData['zipcode'];
            $users->user_detail->mobile = $postData['mobile'];
            $users->status = $postData['status'];
            $users->push();

            return redirect()->route('users.list')->with('status', 'success')->with('message', 'User details ' . Config::get('constants.SUCCESS.UPDATE_DONE'));
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }
    // End Method update_record

    /*
    Method Name:    change_password
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        To update password form
    Params:         [id]
    */
    public function change_password($id)
    {
        $userDetail = User::role('User')->find($id);
        if (!$userDetail) {
            return redirect()->route('users.list');
        }

        return view('admin.users.password', compact('id'));
    }
    // End Method change_password

    /*
    Method Name:    update_password
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        To update password of user
    Params:         [password, password_confirmation]
    */
    public function update_password(Request $request)
    {
        $postData = $request->all();
        $id = $postData['edit_record_id'];
        $request->validate([
            'password' => 'required_with:password_confirmation|string|confirmed',
        ], [
            'password.required' => 'Password is required',
            'password.confirmed' => 'Confirmed Password not matched with password',
        ]);

        try {
            $data = [
                'password' => bcrypt($postData['password']),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $record = User::where('id', $id)->update($data);

            return redirect()->route('users.list')->with('status', 'success')->with('message', 'User password ' . Config::get('constants.SUCCESS.UPDATE_DONE'));
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }
    // End Method update_password

    /*
    Method Name:    change_status
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        To change the status of user[active/inactive]
    Params:         [id, status]
    */
    public function change_status(Request $request)
    {
        $getData = $request->all();
        $user = User::find($getData['id']);
        $user->status = $getData['status'];
        $user->save();

        return redirect()->back()->with('status', 'success')->with('message', 'User ' . Config::get('constants.SUCCESS.STATUS_UPDATE'));
    }
    // End Method change_status

    /*
    Method Name:    view_detail
    Developer:      Shine Dezign
    Created Date:   2021-03-10 (yyyy-mm-dd)
    Purpose:        To get detail of customer profile & Bookings
    Params:         [id]
    */
    public function view_detail($id, Request $request)
    {
        $userDetail = User::role('User')->find($id);

        if (!$userDetail) {
            return redirect()->route('users.list');
        }

        $bookings = Booking::when($request->search_keyword, function ($q) use ($request): void {
            $q->where('booking_name', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('date', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('booking_email', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('status', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('id', $request->search_keyword)
                ->orWhereHas('venue', function ($query) use ($request): void {
                $query->where('name', 'like', '%' . $request->search_keyword . '%');
            });
        })
            ->with(['venue'])->where('bookings.user_id', $id)->sortable('id')->paginate(Config::get('constants.PAGINATION_NUMBER'));

        return view('admin.users.view_detail', compact('userDetail', 'bookings'));
    }

    // End Method view_detail
}

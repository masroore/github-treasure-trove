<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use App\UserDetails;
use App\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class OwnerManageController extends Controller
{
    public function __construct()
    {
    }

    /*
    Method Name:    getList
    Developer:      Shine Dezign
    Created Date:   2021-03-09 (yyyy-mm-dd)
    Purpose:        To get list of all venue owners
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
                ->orWhere('id', $request->search_keyword)
                ->orWhereHas('venue', function ($query) use ($request): void {
                $query->where('name', 'like', '%' . $request->search_keyword . '%');
            });
        })->role('Owner')->sortable('id')->paginate(Config::get('constants.PAGINATION_NUMBER'));

        return view('admin.owners.list', compact('data', 'keyword'));
    }
    // End Method getList

    /*
    Method Name:    add_form
    Developer:      Shine Dezign
    Created Date:   2021-03-25 (yyyy-mm-dd)
    Purpose:        Form to add owner details
    Params:         [id]
    */
    public function add_form()
    {
        return view('admin.owners.add');
    }
    // End Method add_form

    /*
    Method Name:    add_record
    Developer:      Shine Dezign
    Created Date:   2021-03-09 (yyyy-mm-dd)
    Purpose:        To update owner details
    Params:         [edit_record_id, first_name, last_name, email, role, address, zipcode, mobile, status]
    */
    public function add_record(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required_with:password_confirmation|string|confirmed',
            'address' => '',
            'zipcode' => 'required|numeric',
            'mobile' => 'required|numeric',
            // 'status' => 'required'
        ], [
            'password.required' => 'Password is required',
            'password.confirmed' => 'Confirmed Password not matched with password',
        ]);

        try {
            $data = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'password' => bcrypt($request->password),
                'email' => $request->email,
                'status' => 1,
            ];
            $user = User::create($data);
            if ($user) {
                $user->syncRoles('Owner');
                $details = [
                    'user_id' => $user->id,
                    'address' => $request->address,
                    'zipcode' => $request->zipcode,
                    'mobile' => $request->mobile,
                ];
                $result = UserDetails::create($details);
                if ($result) {
                    return redirect()->route('owners.list')->with('status', 'success')->with('message', 'Owner ' . Config::get('constants.SUCCESS.CREATE_DONE'));
                }
            }

            return redirect()->back()->with('status', 'error')->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }
    // End Method add_record

    /*
    Method Name:    del_record
    Developer:      Shine Dezign
    Created Date:   2021-03-09 (yyyy-mm-dd)
    Purpose:        To delete any venue owner by id
    Params:         [id]
    */
    public function del_record(Request $request)
    {
        try {
            $getData = $request->all();
            $venues = Venue::where('user_id', $getData['id'])->pluck('id')->all();
            $bookings = Booking::whereIn('venue_id', $venues)->count();

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
                Venue::where('user_id', $getData['id'])->delete();
                User::find($getData['id'])->delete();

                $status = 'DELETE_DONE';
            }

            return redirect()->back()->with('status', 'success')->with('message', 'Owner ' . Config::get('constants.SUCCESS.' . $status));
        } catch (Exception $ex) {
            return redirect()->back()->with('status', 'error')->with('message', $ex->getMessage());
        }
    }

    // End Method del_record
    /*
    Method Name:    edit_form
    Developer:      Shine Dezign
    Created Date:   2021-03-09 (yyyy-mm-dd)
    Purpose:        Form to update owner details
    Params:         [id]
    */
    public function edit_form($id)
    {
        $ownerDetail = User::role('Owner')->find($id);
        if (!$ownerDetail) {
            return redirect()->route('owners.list');
        }
        $roles = Role::get();

        return view('admin.owners.edit', compact('ownerDetail', 'roles'));
    }
    // End Method edit_form

    /*
    Method Name:    update_record
    Developer:      Shine Dezign
    Created Date:   2021-03-09 (yyyy-mm-dd)
    Purpose:        To update owner details
    Params:         [edit_record_id, first_name, last_name, email, role, address, zipcode, mobile, status]
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
            $users->syncRoles('Owner');
            $users->first_name = $postData['first_name'];
            $users->last_name = $postData['last_name'];
            $users->email = $postData['email'];
            $users->user_detail->address = $postData['address'];
            $users->user_detail->zipcode = $postData['zipcode'];
            $users->user_detail->mobile = $postData['mobile'];
            $users->status = $postData['status'];
            $users->push();

            return redirect()->route('owners.list')->with('status', 'success')->with('message', 'Owner details ' . Config::get('constants.SUCCESS.UPDATE_DONE'));
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
        $ownerDetail = User::role('Owner')->find($id);
        if (!$ownerDetail) {
            return redirect()->route('owners.list');
        }

        return view('admin.owners.password', compact('id'));
    }
    // End Method change_password

    /*
    Method Name:    update_password
    Developer:      Shine Dezign
    Created Date:   2021-03-09 (yyyy-mm-dd)
    Purpose:        To update password of owner
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

            return redirect()->route('owners.list')->with('status', 'success')->with('message', 'Owner password ' . Config::get('constants.SUCCESS.UPDATE_DONE'));
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }
    // End Method update_password

    /*
    Method Name:    change_status
    Developer:      Shine Dezign
    Created Date:   2021-03-09 (yyyy-mm-dd)
    Purpose:        To change the status of owner[active/inactive]
    Params:         [id, status]
    */
    public function change_status(Request $request)
    {
        $getData = $request->all();
        $user = User::find($getData['id']);
        $user->status = $getData['status'];
        $user->save();

        return redirect()->back()->with('status', 'success')->with('message', 'Owner ' . Config::get('constants.SUCCESS.STATUS_UPDATE'));
    }

    // End Method change_status
    /*
    Method Name:    view_detail
    Developer:      Shine Dezign
    Created Date:   2021-03-09 (yyyy-mm-dd)
    Purpose:        To get detail of owner profile & Bookings
    Params:         [id]
    */
    public function view_detail($id, Request $request)
    {
        $ownerDetail = User::role('Owner')->find($id);
        if (!$ownerDetail) {
            return redirect()->route('owners.list');
        }

        $venuesBooking = Venue::when($request->search_keyword, function ($q) use ($request): void {
            $q->where('name', 'like', '%' . $request->search_keyword . '%')
                ->orWhere('id', $request->search_keyword)
                ->orWhereHas('booking', function ($query) use ($request): void {
                $query->where('booking_name', 'like', '%' . $request->search_keyword . '%')
                    ->orWhere('date', 'like', '%' . $request->search_keyword . '%')
                    ->orWhere('booking_email', 'like', '%' . $request->search_keyword . '%')

                    ->orWhereHas('user', function ($qa) use ($request): void {
                        $qa->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", '%' . $request->search_keyword . '%');
                    });
            });
        })
            ->with(['booking'])->where('user_id', $id)->sortable('id')->paginate(Config::get('constants.PAGINATION_NUMBER'));

        return view('admin.owners.view_detail', compact('ownerDetail', 'venuesBooking'));
    }

    // End Method view_detail

    /*
    Method Name:    confirm_request
    Developer:      Shine Dezign
    Created Date:   2021-03-09 (yyyy-mm-dd)
    Purpose:        To accept/decline account request
    Params:         [id]
    */
    public function confirm_request(Request $request)
    {
        try {
            $getData = $request->all();
            $user = User::find($getData['id']);
            $user->is_approved = $getData['is_approved'];
            $user->save();
            if ($getData['is_approved'] == 1) {
                $status = 'APPROVED_DONE';
            } else {
                $status = 'DECLINED_DONE';
            }

            return redirect()->back()->with('status', 'success')->with('message', 'Account ' . Config::get('constants.SUCCESS.' . $status));
        } catch (Exception $ex) {
            return redirect()->back()->with('status', 'error')->with('message', $ex->getMessage());
        }
    }
    // End Method confirm_request
}

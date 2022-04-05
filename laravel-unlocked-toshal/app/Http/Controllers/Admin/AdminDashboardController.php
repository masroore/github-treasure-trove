<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use App\PasswordReset;
use App\Traits\AutoResponderTrait;
use App\User;
use App\UserDetails;
use App\Venue;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Image;
use Session;

class AdminDashboardController extends Controller
{
    use AutoResponderTrait;

    public function __construct()
    {
    }

    /*
    Method Name:    index
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        To display dashboard for admin after login
    Params:         []
    */
    public function index(Request $request)
    {

        // Show dashboard stats
        $users_details = UserDetails::where('user_id', Auth::user()->id)
            ->first();
        $user_count = User::role('User')->count();
        $owner_count = User::role('Owner')->count();
        $venue_count = Venue::count();
        $featured_venue = Venue::where('is_featured', 1)->count();

        $bookings = Booking::where('is_deleted', 0)->get();
        $bookingCount = Booking::where('is_deleted', 0)->groupBy(DB::raw('DATE_FORMAT(date,"%Y-%m")'))->get();

        //booking analytics
        $bookingChart = [];
        if ($bookingCount) {
            foreach ($bookingCount as $bookingC) {
                $bookingCount = Booking::where('is_deleted', 0)->where('date', 'like', '%' . date('Y-m', strtotime($bookingC->date)) . '%')->count();
                $dated = date('m', strtotime($bookingC->date));
                $bookingChart[] = [$dated, $bookingCount];
            }
            $bookingChart = json_encode($bookingChart);
        }

        $events = [];
        //booking data for calender
        foreach ($bookings as $booking) {
            $events[] = [
                'title' => $booking->booking_name,
                'start' => $booking->date,
                'url' => url('/admin/booking/details/' . $booking->id),
            ];
        }
        $bookingEvent = json_encode($events);

        if ($users_details != null) { //if exist
            Session::put('userdetails', $users_details);
        }

        return view('admin.home', compact('user_count', 'owner_count', 'venue_count', 'bookingEvent', 'bookingChart', 'featured_venue'));
    }
    // End Method index

    /*
    Method Name:    login
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        Admin login form
    Params:         []
    */
    public function login()
    {
        if (auth::check()) {
            return redirect()->route('admindashboard');
        }

        return view('admin.loginform');
    }
    // End Method login

    /*
    Method Name:    login_check
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        Admin login credentials check
    Params:         [email, password]
    */
    public function login_check(Request $request)
    {
        $input = $request->all();

        $this->validate($request, ['email' => 'required|email', 'password' => 'required']);

        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if (auth()
            ->attempt([
                $fieldType => $input['email'],
                'password' => $input['password'],
                'status' => 1,
            ])) {
            return redirect()->route('admindashboard');
        }

        return redirect()
            ->route('admin')
            ->with('status', 'Error')
            ->with('message', Config::get('constants.ERROR.WRONG_CREDENTIAL'));
    }
    // End Method login_check

    /*
    Method Name:    logout
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        Logout user
    Params:
    */
    public function logout()
    {
        Auth::logout();

        return redirect()->to('/');
    }
    // End Method logout

    /*
    Method Name:    password_reset
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        Form for forgot password
    Params:
    */
    public function password_reset()
    {
        return view('admin.passwordreset');
    }
    // End Method password_reset

    /*
    Method Name:    password_reset_link
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        Send reset password link email if admin email exist
    Params:         [email]
    */
    public function password_reset_link(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
        $roles = ['Owner', 'User'];

        $adminRoles = [];
        foreach ($this->getAdminRoles($roles) as $row) {
            $adminRoles[] = $row->name;
        }

        $user = User::role($adminRoles)->where('email', $request->email)
            ->first();

        $template = $this->get_template_by_name('FORGOT_PASSWORD');

        if (!$user) {
            return redirect()->back()
                ->with('status', 'Error')
                ->with('message', Config::get('constants.ERROR.WRONG_CREDENTIAL'));
        }
        $passwordReset = PasswordReset::updateOrCreate(['email' => $user->email], ['email' => $user->email, 'token' => Str::random(12)]);

        $link = route('tokencheck', $passwordReset->token);
        $string_to_replace = [
            '{{$name}}',
            '{{$token}}',
        ];
        $string_replace_with = [
            'Admin',
            $link,
        ];
        $newval = str_replace($string_to_replace, $string_replace_with, $template->template);

        $logId = $this->email_log_create($user->email, $template->id, 'FORGOT_PASSWORD');
        $result = $this->send_mail($user->email, $template->subject, $newval);
        if ($result) {
            $this->email_log_update($logId);

            return redirect()->route('resetpassword')
                ->with('status', 'Success')
                ->with('message', Config::get('constants.SUCCESS.RESET_LINK_MAIL'));
        }

        return redirect()
            ->route('resetpassword')
            ->with('status', 'Error')
            ->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
    }
    // End Method password_reset_link

    /*
    Method Name:    password_reset_token_check
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        Checked reset access token
    Params:         [token]
    */
    public function password_reset_token_check($token)
    {
        if (auth::check()) {
            return redirect()->route('admindashboard');
        }
        $passwordReset = PasswordReset::where('token', $token)->first();
        if (!$passwordReset) {
            return redirect()->route('resetpassword')
                ->with('status', 'Error')
                ->with('message', Config::get('constants.ERROR.TOKEN_INVALID'));
        }

        if (Carbon::parse($passwordReset->updated_at)
            ->addMinutes(240)
            ->isPast()) {
            $passwordReset->delete();

            return redirect()
                ->route('resetpassword')
                ->with('status', 'Error')
                ->with('message', Config::get('constants.ERROR.TOKEN_INVALID'));
        }
        Session::put('forgotemail', $passwordReset->email);

        return redirect()
            ->route('setnewpassword');
        // ->with('status', 'Success')
            // ->with('message', 'Set your new password');
    }
    // End Method password_reset_token_check

    /*
    Method Name:    new_password_set
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        Form to set new password after reset password
    Params:
    */
    public function new_password_set()
    {
        if (Session::has('forgotemail')) {
            return view('admin.setnewpassword');
        }

        return redirect()
            ->route('resetpassword')
            ->with('status', 'Error')
            ->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
    }
    // End Method new_password_set

    /*
    Method Name:    update_new_password
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        To update new password after reset pasword
    Params:         [password]
    */
    public function update_new_password(Request $request)
    {
        if (!Session::has('forgotemail')) {
            return redirect()->route('resetpassword')
                ->with('status', 'Error')
                ->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
        }
        $email = Session::get('forgotemail');
        $request->validate([
            'password' => 'required_with:password_confirmation|string|confirmed',
        ], [
            'password.required' => 'Password field is required',
            'password.confirmed' => 'Confirm Password must be same as new password',
        ]);

        try {
            $data = [
                'password' => bcrypt($request->password),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $record = User::where('email', $email)->update($data);
            PasswordReset::where('email', $email)->delete();
            Session::forget('forgotemail');

            return redirect()
                ->route('admin')
                ->with('status', 'success')
                ->with('message', 'Your password ' . Config::get('constants.SUCCESS.UPDATE_DONE'));
        } catch (Exception $e) {
            return redirect()->back()
                ->with('status', 'error')
                ->with('message', $e->getMessage());
        }
    }
    // End Method update_new_password

    /*
    Method Name:    update_record
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        To update admin details
    Params:         [adminemail, first_name, last_name, profile_pic]
    */
    public function update_record(Request $request)
    {
        $validator = Validator::make($request->all(), ['adminemail' => 'required|email|unique:users,email,' . Auth::user()->id, 'first_name' => 'required', 'last_name' => 'required']);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()
                    ->json(['success' => false, 'errors' => $validator->getMessageBag()
                    ->toArray(), ], 422);
            }
        }

        try {
            $postData = $request->all();
            $data = [
                'email' => $postData['adminemail'],
                'first_name' => $postData['first_name'],
                'last_name' => $postData['last_name'],
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            //If Admin uploaded profile pictuce
            if ($request->hasFile('profile_pic')) {
                $allowedfileExtension = ['jpg', 'png'];
                $file = $request->file('profile_pic');
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $image_resize = Image::make($file)->resize(null, 90, function ($constraint): void {
                        $constraint->aspectRatio();
                    })
                        ->encode($extension);
                    $users_details = UserDetails::where('user_id', Auth::user()->id)
                        ->first();
                    if ($users_details == null) {
                        $users_details = UserDetails::create(['user_id' => Auth::user()->id, 'profile_picture' => $image_resize, 'imagetype' => $extension, 'status' => 1, 'created_at' => date('Y-m-d H:i:s')]);
                    } else {
                        $users_details->update(['profile_picture' => $image_resize, 'imagetype' => $extension, 'updated_at' => date('Y-m-d H:i:s')]);
                    }
                } else {
                    return response()->json(['success' => false, 'msg' => 'Please select png or jpg images.'], 200);
                }
            }
            $record = User::where('id', Auth::user()->id)
                ->update($data);
            if ($record > 0) {
                $users_details = UserDetails::where('user_id', Auth::user()->id)
                    ->first();
                if ($users_details != null) {
                    Session::put('userdetails', $users_details);
                }

                return response()->json(['success' => true, 'msg' => 'User details ' . Config::get('constants.SUCCESS.UPDATE_DONE')], 200);
            }

            return response()
                ->json(['success' => false, 'msg' => Config::get('constants.ERROR.OOPS_ERROR')], 200);
        } catch (Exception $e) {
            throw $e;

            return response()->json(['success' => false, 'msg' => $e], 200);
        }
    }
    // End Method update_record

    /*
    Method Name:    update_password
    Developer:      Shine Dezign
    Created Date:   2021-03-08 (yyyy-mm-dd)
    Purpose:        To update admin password
    Params:         [oldpassword, newpassword]
    */
    public function update_password(Request $request)
    {
        $validator = Validator::make($request->all(), ['oldpassword' => 'required', 'newpassword' => 'required']);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()
                    ->json(['success' => false, 'errors' => $validator->getMessageBag()
                    ->toArray(), ], 422);
            }
        }
        $hashedPassword = Auth::user()->password;
        if (\Hash::check($request->oldpassword, $hashedPassword)) {
            if (!\Hash::check($request->newpassword, $hashedPassword)) {
                $users = User::find(Auth::user()->id);
                $users->password = bcrypt($request->newpassword);
                $users->save();

                return response()
                    ->json(['success' => true, 'msg' => 'User password updated Successfully'], 200);
            }

            return response()
                ->json(['success' => false, 'msg' => 'New password can not be the old password'], 200);
        }

        return response()
            ->json(['success' => false, 'msg' => 'Old password doesnt matched'], 200);
    }
    // End Method update_password
}

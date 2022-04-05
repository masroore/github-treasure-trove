<?php

namespace App\Http\Controllers\Frontend;

use App\Amenity;
use App\Booking;
use App\Http\Controllers\Controller;
use App\PasswordReset;
use App\Traits\AutoResponderTrait;
use App\User;
use App\UserDetails;
use App\Venue;
use App\VenueAmenity;
use App\VenueImage;
use Carbon\Carbon;
use Exception;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Image;
use Session;

class UserController extends Controller
{
    use AutoResponderTrait;

    public function __construct()
    {
    }

    /*
    Method Name:    index
    Developer:      Shine Dezign
    Created Date:   2021-03-30 (yyyy-mm-dd)
    Purpose:        To display dashboard for user after login
    Params:         []
    */
    public function index()
    {
        $user = User::find(Auth::user()->id);

        $users_details = UserDetails::where('user_id', Auth::user()->id)
            ->first();
        if ($users_details != null) { //if exist
            Session::put('userdetails', $users_details);
        }
        $userDetail = User::with('user_detail')->find(Auth::user()->id);
        if (!$userDetail) {
            return redirect()->route('logout');
        }
        //Venue Owner Dashboard detail
        $events = [];
        $bookings = [];
        $venues = $userDetail->venue;

        //booking data for calender
        if ($venues->count() > 0) {
            foreach ($venues as $venue) {
                foreach ($venue->booking as $booking) {
                    $events[] = [
                        'title' => $booking->booking_name,
                        'start' => $booking->date,
                    ];
                }
            }
        }
        $bookingEvent = json_encode($events);
        //End
        return view('user.dashboard', compact('userDetail', 'bookingEvent'));
    }
    // End Method index

    /*
    Method Name:    add_form
    Developer:      Shine Dezign
    Created Date:   2021-03-22 (yyyy-mm-dd)
    Purpose:        Form to add venue details
    Params:         []
    */
    public function add_form()
    {
        $amenities = Amenity::get();
        $selectedAmenities = [];
        $venuAmenities = VenueAmenity::where('venue_id', 3)->first();
        if ($venuAmenities) {
            $selectedAmenities = explode(',', $venuAmenities->amenity_id);
        }

        return view('user.venues.add', compact('amenities', 'selectedAmenities'));
    }
    // End Method add_form

    /*
    Method Name:    add_record
    Developer:      Shine Dezign
    Created Date:   2021-03-22 (yyyy-mm-dd)
    Purpose:        To add venue
    Params:         [name, location, building_type, total_room,booking_price,contact,venue_image_name[], status]
    */
    public function insert_record(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'no_of_people' => 'required|numeric',
            'building_type' => 'required',
            'total_room' => 'required|numeric',
            'booking_price' => 'required|numeric',
            'contact' => 'required|numeric',
            'status' => '',
            'venue_image_name[]' => 'image|mimes:jpeg,png,jpg',
        ], [
            'venue_image_name.mimes' => 'Choose the image jpg,jpeg or png format Only',
            'venue_image_name.image' => 'Choose the image Only',
            'user_id.required' => 'Owner name is required',
        ]);

        try {
            $imgArr = [];

            $data = [
                'name' => $request->name,

                'user_id' => 2,
                // Auth::user()->id,
                'location' => $request->location,
                'building_type' => $request->building_type,
                'total_room' => $request->total_room,
                'booking_price' => $request->booking_price,
                'no_of_people' => $request->no_of_people,
                'contact' => $request->contact,
                'other_information' => $request->other_information,
                'status' => 1,
            ];
            $record = Venue::create($data);

            $venueId = $record->id;
            if ($venueId) {
                if ($request['amenity_id'] != '') {
                    $amenity_id = implode(',', $request['amenity_id']);
                    VenueAmenity::create(['venue_id' => $venueId, 'amenity_id' => $amenity_id]);
                }

                if ($request->file('venue_image_name')) {
                    $venuImg = $request->file('venue_image_name');
                    $uploadpath = public_path() . '/assets/venue/images/';
                    foreach ($venuImg as $key => $img) {
                        $file = $img;
                        $orignlname = $img->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $slug = Str::slug($request->name);
                        $documentname = $slug . '-' . $orignlname;

                        $image_path = $uploadpath . '/' . $documentname; // Value is not URL but directory file path

                        $imgArr[] = ['venue_id' => $venueId, 'name' => $documentname, 'status' => 1];
                        $file->move($uploadpath, $documentname);
                    }
                    if (count($imgArr)) {
                        VenueImage::insert($imgArr);
                    }
                }
                // $routes = ($request->action == 'saveadd') ? 'venues.add' : 'venues.list';
                return redirect()->back()->with('status', 'success')->with('message', 'Venue ' . Config::get('constants.SUCCESS.CREATE_DONE'));
            }

            return redirect()
                ->back()->with('status', 'error')
                ->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
        } catch (Exception $e) {
            return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }
    // End Method add_record

    /*
    Method Name:    edit_form
    Developer:      Shine Dezign
    Created Date:   2021-03-30 (yyyy-mm-dd)
    Purpose:        Form to update user details
    Params:         [id]
    */
    public function edit_form()
    {
        $userDetail = User::with('user_detail')->find(Auth::user()->id);
        if (!$userDetail) {
            return redirect()->route('userdashboard');
        }

        return view('user.editprofile', compact('userDetail'));
    }
    // End Method edit_form

    /*
    Method Name:    view_detail
    Developer:      Shine Dezign
    Created Date:   2021-03-30 (yyyy-mm-dd)
    Purpose:        view profile details
    Params:         [id]
    */
    public function view_detail()
    {
        $userDetail = User::find(Auth::user()->id);
        if (!$userDetail) {
            return redirect()->route('userdashboard');
        }

        return view('user.view_detail', compact('userDetail'));
    }
    // End Method edit_form

    /*
    Method Name:    edit_form
    Developer:      Shine Dezign
    Created Date:   2021-03-30 (yyyy-mm-dd)
    Purpose:        Form to update user details
    Params:         [id]
    */
    public function edit_password()
    {
        if (Auth::user()->id) {
            return view('user.changepassword');
        }
    }
    // End Method edit_form

    /*
    Method Name:    password_reset
    Developer:      Shine Dezign
    Created Date:   2021-03-09 (yyyy-mm-dd)
    Purpose:        Form for forgot password
    Params:
    */
    public function password_reset()
    {
        if (auth::check()) {
            return redirect()->route('userdashboard');
        }

        return view('user.passwordreset');
    }
    // End Method password_reset

    /*
    Method Name:    password_reset_link
    Developer:      Shine Dezign
    Created Date:   2021-03-30 (yyyy-mm-dd)
    Purpose:        Send reset password link email if user email exist
    Params:         [email]
    */
    public function password_reset_link(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $user = User::role('User')->where('email', $request->email)
            ->first();
        $template = $this->get_template_by_name('FORGOT_PASSWORD');

        if (!$user) {
            return redirect()->back()
                ->with('status', 'error')
                ->with('message', Config::get('constants.ERROR.WRONG_CREDENTIAL'));
        }
        $passwordReset = PasswordReset::updateOrCreate(['email' => $user->email], ['email' => $user->email, 'token' => Str::random(12)]);

        $link = route('checktoken', $passwordReset->token);
        $string_to_replace = [
            '{{$name}}',
            '{{$token}}',
        ];
        $string_replace_with = [
            'User',
            $link,
        ];
        $newval = str_replace($string_to_replace, $string_replace_with, $template->template);

        $logId = $this->email_log_create($user->email, $template->id, 'FORGOT_PASSWORD');
        $result = $this->send_mail($user->email, $template->subject, $newval);
        if ($result) {
            $this->email_log_update($logId);

            return redirect()->route('password.reset')
                ->with('status', 'success')
                ->with('message', Config::get('constants.SUCCESS.RESET_LINK_MAIL'));
        }

        return redirect()
            ->route('password.reset')
            ->with('status', 'error')
            ->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
    }
    // End Method password_reset_link

    /*
    Method Name:    password_reset_token_check
    Developer:      Shine Dezign
    Created Date:   2021-03-30 (yyyy-mm-dd)
    Purpose:        Checked reset access token
    Params:         [token]
    */
    public function password_reset_token_check($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();
        if (!$passwordReset) {
            return redirect()->route('password.reset')
                ->with('status', 'error')
                ->with('message', Config::get('constants.ERROR.TOKEN_INVALID'));
        }

        if (Carbon::parse($passwordReset->updated_at)
            ->addMinutes(240)
            ->isPast()) {
            $passwordReset->delete();

            return redirect()
                ->route('password.reset')
                ->with('status', 'error')
                ->with('message', Config::get('constants.ERROR.TOKEN_INVALID'));
        }
        Session::put('forgotemail', $passwordReset->email);

        return redirect()
            ->route('usersetnewpassword');
    }
    // End Method password_reset_token_check

    /*
    Method Name:    new_password_set
    Developer:      Shine Dezign
    Created Date:   2021-03-09 (yyyy-mm-dd)
    Purpose:        Form to set new password after reset password
    Params:
    */
    public function new_password_set()
    {
        if (auth::check()) {
            return redirect()->route('userdashboard');
        }
        if (Session::has('forgotemail')) {
            return view('user.setnewpassword');
        }

        return redirect()
            ->route('password.reset')
            ->with('status', 'error')
            ->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
    }

    // End Method new_password_set
    /*
    Method Name:    update_new_password
    Developer:      Shine Dezign
    Created Date:   2021-03-30 (yyyy-mm-dd)
    Purpose:        To update new password after reset pasword
    Params:         [password]
    */
    public function update_new_password(Request $request)
    {
        if (!Session::has('forgotemail')) {
            return redirect()->route('password.reset')
                ->with('status', 'error')
                ->with('message', Config::get('constants.ERROR.OOPS_ERROR'));
        }
        $email = Session::get('forgotemail');
        $request->validate(
            [
                'password' => 'required_with:password_confirmation|string|confirmed',
            ],
            [
                'password.required' => 'Password field is required',
                'password.confirmed' => 'Confirm Password must be same as new password',
            ]
        );

        try {
            $data = [
                'password' => bcrypt($request->password),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $record = User::where('email', $email)->update($data);
            PasswordReset::where('email', $email)->delete();
            Session::forget('forgotemail');

            return redirect()
                ->route('login')
                ->with('status', 'success')
                ->with('message', 'Your password ' . Config::get('constants.SUCCESS.UPDATE_DONE'));
        } catch (Exception $e) {
            return redirect()->back()
                ->with('status', 'error')
                ->with('message', $e->getMessage());
        }
    }

    /*
    Method Name:    update_record
    Developer:      Shine Dezign
    Created Date:   2021-03-30 (yyyy-mm-dd)
    Purpose:        To update user details
    Params:         [useremail, first_name, last_name, profile_picture]
    */
    public function update_record(Request $request)
    {
        $postData = $request->all();
        $request->validate([
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            'address' => 'max:200',
            'mobile' => 'required|numeric|unique:user_details,mobile,' . Auth::user()->id . ',user_id',
            'profile_picture' => 'image|mimes:jpeg,png,jpg',
        ]);

        try {
            // If User uploaded profile picture
            if ($request->hasFile('profile_picture')) {
                $allowedfileExtension = ['jpg', 'png', 'jpeg'];
                $file = $request->file('profile_picture');
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
                    Session::put('userdetails', $users_details);
                } else {
                    return redirect()->back()->with('status', 'error')->with('message', 'Please select png,jpeg or jpg images.');

                    // return response()->json(["success" => false, "msg" => "Please select png,jpeg or jpg images."], 200);
                }
            }
            // End User uploaded profile picture

            $users = User::findOrFail(Auth::user()->id);

            $users->first_name = $postData['first_name'];
            $users->last_name = $postData['last_name'];
            $users->email = $postData['email'];
            $users->user_detail->address = $postData['address'];
            $users->user_detail->country = $postData['country'];
            $users->user_detail->city = $postData['city'];
            $users->user_detail->zipcode = $postData['zipcode'];
            $users->user_detail->mobile = $postData['mobile'];
            $users->push();

            return redirect()->route('detail.update')->with('status', 'success')->with('message', 'Profile ' . Config::get('constants.SUCCESS.UPDATE_DONE'));
        } catch (Exception $e) {
            return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }

    // End Method update_record
    public function remove_photo(Request $request)
    {
        try {
            $users = Session::get('userdetails'); // Get the array
            unset($users['profile_picture'], $users['imagetype']);
             // Unset the index you want
            Session::put('userdetails', $users);

            UserDetails::where('user_id', Auth::user()->id)->update(['profile_picture' => '', 'imagetype' => '']);

            return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back()->with('status', 'error')->with('message', $e->getMessage());
        }
    }

    /*
    Method Name:    update_password
    Developer:      Shine Dezign
    Created Date:   2021-03-30 (yyyy-mm-dd)
    Purpose:        To update user password
    Params:         [oldpassword, newpassword]
    */
    public function update_password(Request $request)
    {
        $request->validate([
            'currentpassword' => 'required',
            'newpassword' => 'required|min:6',
            'confirmpassword' => 'required|same:newpassword',
        ]);
        $hashedPassword = Auth::user()->password;
        if (\Hash::check($request->currentpassword, $hashedPassword)) {
            if (!\Hash::check($request->newpassword, $hashedPassword)) {
                $users = User::find(Auth::user()->id);
                $users->password = bcrypt($request->newpassword);
                $users->save();

                return redirect()->route('change.password')->with('status', 'success')->with('message', 'User password updated successfully');
            }

            return redirect()->back()->with('status', 'error')->with('message', 'New password can not be the old password!');
        }

        return redirect()->back()->with('status', 'error')->with('message', 'Old password doesnt matched');
    }
    // End Method update_password
}

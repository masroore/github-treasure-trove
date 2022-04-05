<?php

namespace Modules\AdminApi\Http\Controllers\v1\customer;

use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerUser;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CustomerAuthController extends Controller
{
    private $errors = [];

    public function login(Request $request)
    {
        $user = CustomerUser::where('email', $request->email)->first();

        // check if user of given email exists
        if (!$user) {
            return response()->json([
                'status' => false,
                'error' => 'Invalid email or password provided.',
            ], 200);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'error' => 'Invalid email or password provided.',
            ], 200);
        }

        $token = $user->createToken('speedy-orders-token')->plainTextToken;
        if (1 == $user->status) {
            $user->status = 'active';
        } else {
            $user->status = 'inactive';
        }
        $response = [
            'status' => true,
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 200);
    }

    public function user()
    {
        $user = CustomerUser::where('id', request()->user()->id)->with('customer', 'addresses')->first();
        if ('1' == $user->status) {
            $user->status = 'Active';
        } else {
            $user->status = 'Inactive';
        }

        return $user;

        // $response = [
        //     'status'=>true,
        //     'user' => auth()->user(),
        // ];

        //  return response($response, 200);
    }

    public function resetPassword(Request $request)
    {
        if (!isset($request->email)) {
            return response([
                'status' => false,
                'msg' => 'Please enter email',

            ], 200);
        }

        if (!filter_var($request->email, \FILTER_VALIDATE_EMAIL)) {
            return response([
                'status' => false,
                'msg' => 'Invalid email',

            ], 200);
        }

        $customerUser = CustomerUser::where('email', $request->email)->first();

        if (!$customerUser) {
            return response([
                'status' => false,
                'msg' => 'Sorry,Email address not found on our database',

            ], 200);
        }

        $token = Str::random(64);

        $customerUser->update(
            ['token' => $token, 'password_reset_at' => Carbon::now()]
        );

        Mail::send('emails.reset-password', ['token' => $token, 'email' => $request->email], function ($message) use ($request): void {
            $message->to($request->email);
            $message->subject('Reset Password Notification');
        });

        return response([
            'status' => true,
            'msg' => 'Password reset link sent successfully.Please check your email.',
        ], 200);
    }

    public function resetPasswordMail($token, $email)
    {
        $customerUser = CustomerUser::where('email', $email)->where('token', $token)->first();
        $now = Carbon::now();
        if ($now->diffInMinutes(Carbon::parse($customerUser->password_reset_at)) < 60) {
            return redirect('http://localhost:3000/resetpassword/' . $token . '/' . $email);
        }

        return 'Session expired';
    }

    public function updatePassword(Request $request)
    {
        if (!isset($request->email)) {
            return response([
                'status' => false,
                'msg' => 'Please enter email',

            ], 200);
        }

        if (!filter_var($request->email, \FILTER_VALIDATE_EMAIL)) {
            return response([
                'status' => false,
                'msg' => 'Invalid email',

            ], 200);
        }

        if ($request->newPassword != $request->confirmNewPassword) {
            return response([
                'status' => false,
                'msg' => 'Both password must match',

            ], 200);
        }

        $customerUser = CustomerUser::where('email', $request->email)->get()->first();

        if (!$customerUser) {
            return response([
                'status' => false,
                'msg' => 'Sorry,Email address not found on our database',

            ], 200);
        }

        if ($customerUser->token != $request->token) {
            return response([
                'status' => false,
                'msg' => "Sorry,Token doesn't match.",

            ], 200);
        }

        $now = Carbon::now();
        if ($now->diffInMinutes(Carbon::parse($customerUser->password_reset_at)) > 60) {
            return response([
                'status' => false,
                'msg' => 'Sorry,Session has expired try resetting again',
            ], 200);
        }

        $customerUser->update(['password' => Hash::make($request->newPassword)]);

        return response([
            'status' => true,
            'msg' => 'Password reset completed.Login to continue.',
        ], 200);
    }

    public function logout()
    {
        $user = request()->user();

        if (!$user->tokens()->where('id', $user->currentAccessToken()->id)->delete()) {
            return response()->json([
                'status' => false,
                'error' => 'Couldnot logout with the token provided for the user.',
            ], 200);
        }

        return response([
            'status' => true,
            'message' => 'Logout successfully',
        ], 200);
    }

    public function register(Request $request)
    {
        if (!$this->validateParams($request)) {
            return response([
                'status' => false,
                'error' => $this->errors,
                'msg' => 'please Check Your Details !',

            ], 200);
        }
        $dob = Carbon::createFromDate($request->year, $request->month, $request->day);

        try {
            DB::beginTransaction();

            $customerUser = CustomerUser::create([

                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 1,
            ]);

            $customer = Customer::create([
                'customer_user_id' => $customerUser->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'date_of_birth' => $dob,
                'newsletter' => $request->subscribe,
            ]);

            CustomerAddress::create([
                'customer_user_id' => $customerUser->id,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'postcode' => $request->postcode,
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
            ]);

            DB::commit();
            unset($customer['id'], $customer['customer_user_id']);

            return response([
                'status' => true,
                'data' => $customer,
                'msg' => 'New Customer Registered Successfully !',
            ], 200);
        } catch (Exception $e) {
            DB::rollback();

            return $e->getMessage();
        }
    }

    private function validateParams($data)
    {
        $check = true;

        if (!isset($data->first_name)) {
            $this->errors['first_name'] = 'please enter your first name.';
            $check = false;
        }

        if (!isset($data->last_name)) {
            $this->errors['last_name'] = 'please enter your last name.';
            $check = false;
        }

        if (!isset($data->email)) {
            $this->errors['email'] = 'please enter your email.';
            $check = false;
        }

        if (!isset($data->password)) {
            $this->errors['password'] = 'please enter password.';
            $check = false;
        }

        if (!isset($data->gender)) {
            $this->errors['gender'] = 'please select gender.';
            $check = false;
        }

        if (!isset($data->day)) {
            $this->errors['day'] = 'please select day.';
            $check = false;
        }

        if (!isset($data->month)) {
            $this->errors['month'] = 'please select month.';
            $check = false;
        }

        if (!isset($data->year)) {
            $this->errors['year'] = 'please select years';
            $check = false;
        }

        if (isset($data->email) && !filter_var($data->email, \FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'please enter valid email.';
            $check = false;
        }

        if (isset($data->email) && CustomerUser::where('email', $data->email)->first()) {
            $this->errors['email'] = 'User already exists with the given email.';
            $check = false;
        }

        if (!isset($data->phone)) {
            $this->errors['phone'] = 'please enter your phone no';
            $check = false;
        }

        if (!isset($data->country)) {
            $this->errors['country'] = 'please select your country';
            $check = false;
        }

        if (!isset($data->state)) {
            $this->errors['state'] = 'please select your state';
            $check = false;
        }

        if (!isset($data->city)) {
            $this->errors['city'] = 'please enter your city';
            $check = false;
        }
        if (!isset($data->postcode)) {
            $this->errors['postcode'] = 'please enter your postcode';
            $check = false;
        }
        if (!isset($data->address_1)) {
            $this->errors['address_1'] = 'please enter your address_1';
            $check = false;
        }

        return $check;
    }
}

<?php

namespace App\Services;

use App\Jobs\SendEmail;
use App\Jobs\WhatsAppJob;
use App\Models\Notification;
use App\Repositories\EmployeeRepositoryInterface;
use App\Repositories\FavoritesRepositoryInterface;
use App\Repositories\StoreRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use InvalidArgumentException;

class UserService
{
    /**
     * @var
     * @var
     * @var
     * @var
     */
    protected $userRepository;

    protected $storeRepository;

    protected $employeeRepository;

    protected $favoritesRepository;

    /**
     * UserService constructor.
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        StoreRepositoryInterface $storeRepository,
        EmployeeRepositoryInterface $employeeRepository,
        FavoritesRepositoryInterface $favoritesRepository
    ) {
        $this->userRepository = $userRepository;
        $this->storeRepository = $storeRepository;
        $this->employeeRepository = $employeeRepository;
        $this->favoritesRepository = $favoritesRepository;
    }

    /**
     * Register user.
     *
     * @param $request
     *
     * @return $message
     */
    public function register(Request $request)
    {
        try {
            $result = extract_number_and_cc($request);

            $whatsapp = $result['with_cc'];
            $without_cc = $result['without_cc'];
            $request['whatsapp'] = $whatsapp;

            // validate request
            $validator = Validator::make($request->input(), [
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string',
                'user_type' => 'required|string|in:visitor,company',
                'store_name' => 'required_if:user_type,company|unique:stores,store_name',
                'country_code' => 'required',
                'whatsapp' => 'required|string|unique:users,wp_num_inc_code',
                'checkbox' => 'accepted',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $otp = generate_random_string();
            $hash = Hash::make(time() . $request['phone'] . 'whatspays');
            $name = $request['name'];

            // create user
            $user = $this->userRepository->create([
                'name' => $name,
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'user_type' => $request['user_type'],
                'activation_code' => Hash::make($otp),
                'activation_key' => $hash,
                'country_code' => $request['country_code'],
                'wp_num_inc_code' => $whatsapp,
                'wp_num_exc_code' => $without_cc,
                'otp_expiry' => strtotime('now') + (60 * 10),
            ]);

            // create a store for company user
            if ('company' == $request['user_type'] && $user) {
                $create_store = $this->storeRepository->create([
                    'user_id' => $user->id,
                    'store_name' => $request['store_name'],
                    'email' => $request['email'],
                    'whatsapp_num' => $request['whatsapp'],
                ]);
                $this->employeeRepository->create([
                    'user_id' => $user->id,
                    'store_id' => $create_store->id,
                    'is_admin' => 1,
                ]);
            }

            $whatsapp_msg = get_whatsapp_message('customer_support', [
                'name' => $name,
            ]);

            $activation_link = 'https://whatspays.org/user/verify_link/?code=' . urlencode($hash);
            $email_subject = get_email_subject('register', $name);

            // send email in queue
            $email_job = new SendEmail([
                'view' => 'email.register',
                'email' => $request['email'],
                'subject' => $email_subject,
                'name' => $name,
                'activation_code' => $otp,
                'whatsapp_link' => $whatsapp_msg,
                'link' => $activation_link,
            ]);

            // dispatch job
            dispatch($email_job);

            // send whatsapp in queue
            $whatsapp_job = new WhatsAppJob([
                'to' => $whatsapp,
                'data' => [
                    'template_name' => 'register_final',
                    'to' => (int) $whatsapp,
                    'name' => $name,
                    'code' => $otp,
                    'hash' => $hash,
                ],
            ]);

            dispatch($whatsapp_job);

            return $user;
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Login user.
     *
     * @param $request
     *
     * @return $message
     */
    public function login(Request $request)
    {
        try {
            // validate request
            $validator = Validator::make($request->input(), [
                'username' => ['required',
                    function ($attribute, $value, $fail): void {
                        if (!filter_var($value, \FILTER_VALIDATE_EMAIL) && 'WP-' != strtoupper(substr($value, 0, 3))) {
                            $value = (int) (str_replace(' ', '', $value));
                            if ($value <= 0) {
                                $fail('The ' . $attribute . ' is invalid.');
                            }
                        }
                    },

                ],
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $phone = (string) (int) Str::remove([' ', '-'], $request['username']);
            if ($phone > 0) {
                $where = ['wp_num_exc_code' => $phone, 'wp_num_inc_code' => $phone];
            } else {
                $where = ['email' => $request['username']];
            }

            $user = $this->userRepository->findByColumnOr($where, [
                'id',
                'name',
                'image',
                'email',
                'wp_num_inc_code',
                'password',
                'user_status',
                'is_user_deactivated',
                'user_type',
            ], ['stores',
                /*=> function($query) {
                $query->select('stores.id as store_id', 'store_name', 'business_url', 'store_logo', 'whatsapp_num', 'stores.status');
            }*/
            ]);

            //, 'role' => function($query) {
            //                $query->select( 'permissions');
            //            }
            // echo json_encode($user->role());
            if (!$user) {
                throw new InvalidArgumentException(__('user.error.registered'));
            }

            if (!$user || !Hash::check($request['password'], $user->password)) {
                throw new InvalidArgumentException(__('user.error.credentials'));
            }

            // check user status
            $result = $this->checkUserStatus($user);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $result;
    }

    /**
     * save store id against token.
     *
     * @param $store
     *
     * @return $message
     */
    public function default(Request $request, $store)
    {
        try {
            $stores = Auth::user()->stores->where('store_id', $store);

            if ($stores->isEmpty()) {
                throw new InvalidArgumentException(__('user.error.empty', ['attribute' => 'Store']));
            }

            $result = $request->user()->currentAccessToken()->update(['store_id' => $store]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $result;
    }

    /**
     * Verify user with code.
     *
     * @param $request
     *
     * @return $message
     */
    public function verify(Request $request)
    {
        try {
            // validate request
            $validator = Validator::make($request->input(), [
                'email' => 'required|string|email',
                // 'password' => 'required|string',
                'activation_code' => 'required|string',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $user = $this->userRepository->findByColumn([
                'email' => $request['email'],
            ], [
                'id',
                'name',
                'image',
                'email',
                'wp_num_inc_code',
                'activation_code',
                'user_status',
                'is_user_deactivated',
                'user_type',
                'otp_expiry',
            ], ['stores',
                /*=> function($query) {
                $query->select('stores.id as store_id', 'store_name', 'business_url', 'store_logo', 'whatsapp_num', 'stores.status');
            }*/
            ]);

            // check activation code
            if (!Hash::check($request['activation_code'], $user->activation_code)) {
                throw new InvalidArgumentException(__('user.error.code'));
            }

            if (strtotime('now') >= (int) $user->otp_expiry) {
                throw new InvalidArgumentException(__('user.error.code_expired'));
            }

            // update status
            $updated = $this->userRepository->update($user->id, ['user_status' => 1, 'is_user_deactivated' => 0]);

            // check user status
            if ($updated) {
                $user->user_status = 1;
                $user->is_user_deactivated = 0;
                $result = $this->checkUserStatus($user);
                $result['message'] = __('user.success.verified');
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $result;
    }

    /**
     * Verify user with Link.
     *
     * @param $request
     *
     * @return $message
     */
    public function verifyWithLink(Request $request)
    {
        try {
            // check activation key
            $user = $this->userRepository->findByColumn([
                'activation_key' => $request['code'],
            ], [
                'id',
                'name',
                'image',
                'email',
                'wp_num_inc_code',
                'activation_code',
                'user_status',
                'is_user_deactivated',
                'user_type',
                'otp_expiry',
            ], ['stores',
                /*=> function($query) {
                $query->select('stores.id as store_id', 'store_name', 'store_logo', 'business_url', 'whatsapp_num', 'stores.status');
            }*/
            ]);

            if (!$user) {
                throw new InvalidArgumentException(__('user.error.invalid_link'));
            }

            // update status
            $updated = $this->userRepository->update($user->id, ['user_status' => 1]);

            if ($updated) {
                // check user status
                $user->user_status = 1;
                $result = $this->checkUserStatus($user);
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $result;
    }

    /**
     * To resend account activation link via email.
     *
     * @param $request
     *
     * @return $message
     */
    public function resendActivation(Request $request)
    {
        try {
            // validate request
            $validator = Validator::make($request->input(), [
                'username' => ['required', 'string', function ($attribute, $value, $fail): void {
                    if (!filter_var($value, \FILTER_VALIDATE_EMAIL)) {
                        $value = (int) Str::remove(' ', $value);
                        if ($value <= 0) {
                            $fail('The ' . $attribute . ' is invalid.');
                        }
                    }
                }],
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $phone = (string) (int) Str::remove([' ', '-'], $request['username']);

            $user = $this->userRepository->findByColumnOr([
                'email' => $request['username'],
                'wp_num_inc_code' => $phone,
                'wp_num_exc_code' => $phone,
            ]);

            if (!$user) {
                throw new InvalidArgumentException(__('user.error.registered'));
            }

            if (0 != $user->user_status && 0 == $user->is_user_deactivated) {
                throw new InvalidArgumentException(__('user.error.active'));
            }

            $name = $user->name;
            $user_email = $user->email;
            $user_whatsapp = $user->wp_num_inc_code;
            $whatsapp = $user_whatsapp;
            $otp = generate_random_string();
            $hash = Hash::make(time() . $user_whatsapp . 'whatspays');
            $whatsapp_msg = get_whatsapp_message('customer_support', [
                'name' => $name,
            ]);

            $this->userRepository->update($user->id, [
                'activation_code' => Hash::make($otp),
                'activation_key' => $hash,
                'otp_expiry' => strtotime('now') + (60 * 10),
            ]);

            $activation_link = 'https://whatspays.org/user/verify_link/?code=' . urlencode($hash);
            $email_subject = get_email_subject('reactivate', $name);

            // send email in queue
            $email_job = new SendEmail([
                'view' => 'email.reactivate',
                'email' => $user_email,
                'subject' => $email_subject,
                'name' => $name,
                'activation_code' => $otp,
                'whatsapp_link' => $whatsapp_msg,
                'link' => $activation_link,
            ]);

            // dispatch job
            dispatch($email_job);

            $whatsapp_job = new WhatsAppJob([
                'to' => $whatsapp,
                'data' => [
                    'template_name' => 'forgot_password_final_v2',
                    'to' => (int) $whatsapp,
                    'name' => $name,
                    'code' => $otp,
                    'hash' => $hash,
                ],
            ]);

            dispatch($whatsapp_job);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $user;
    }

    /**
     * To resend account activation link via email.
     *
     * @param $request
     *
     * @return $message
     */
    public function resendActivationCode(Request $request)
    {
        try {
            // validate request
            $validator = Validator::make($request->input(), [
                'username' => ['required', 'string', function ($attribute, $value, $fail): void {
                    if (!filter_var($value, \FILTER_VALIDATE_EMAIL)) {
                        $value = (int) Str::remove(' ', $value);
                        if ($value <= 0) {
                            $fail('The ' . $attribute . ' is invalid.');
                        }
                    }
                }],
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $phone = (string) (int) Str::remove([' ', '-'], $request['username']);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $user = $this->userRepository->findByColumnOr([
                'email' => $request['username'],
                'wp_num_inc_code' => $phone,
                'wp_num_exc_code' => $phone,
            ]);

            if (!$user) {
                throw new InvalidArgumentException(__('user.error.registered'));
            }
            if (0 == $user->user_status) {
                $name = $user->name;
                $user_email = $user->email;
                $user_whatsapp = $user->wp_num_inc_code;
                $whatsapp = $user_whatsapp;
                $otp = generate_random_string();
                $otp_expiry = strtotime('now') + (60 * 10);

                $whatsapp_msg = get_whatsapp_message('customer_support', [
                    'name' => $name,
                ]);

                $result = $this->userRepository->update($user->id, [
                    'activation_code' => Hash::make($otp),
                    'otp_expiry' => $otp_expiry,
                ]);

                $email_subject = get_email_subject('resendcode', $name);

                // send email in queue
                $email_job = new SendEmail([
                    'view' => 'email.resendcode',
                    'email' => $user_email,
                    'subject' => $email_subject,
                    'name' => $name,
                    'activation_code' => $otp,
                    'whatsapp_link' => $whatsapp_msg,
                ]);

                // dispatch job
                dispatch($email_job);

                return $result;
            }

            throw new InvalidArgumentException(__('user.error.active'));
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     *Forgot Password link via email or Whatsapp.
     *
     * @param $request
     *
     * @return $message
     */
    public function forgot(Request $request)
    {
        try {
            $validator = Validator::make($request->input(), [
                'username' => ['required', 'string', function ($attribute, $value, $fail): void {
                    if (!filter_var($value, \FILTER_VALIDATE_EMAIL)) {
                        $value = (int) (str_replace(' ', '', $value));
                        if ($value <= 0) {
                            $fail('The ' . $attribute . ' is invalid.');
                        }
                    }
                }],
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $phone = (string) (int) Str::remove([' ', '-'], $request['username']);

            $user = $this->userRepository->findByColumnOr([
                'email' => $request['username'],
                'wp_num_inc_code' => $phone,
                'wp_num_exc_code' => $phone,
            ], [
                'id',
                'name',
                'email',
                'wp_num_inc_code',
                'user_type',
            ]);

            if (!$user) {
                throw new InvalidArgumentException(__('passwords.user'));
            }

            $user_id = $user->id;
            $name = $user->name;
            $user_email = $user->email;
            $user_whatsapp = $user->wp_num_inc_code;
            $whatsapp = $user_whatsapp;
            $otp = generate_random_string();
            $hash = Hash::make(time() . $user_whatsapp . 'whatspays');
            $whatsapp_msg = get_whatsapp_message('customer_support', [
                'name' => $name,
            ]);

            $this->userRepository->update($user_id, [
                'activation_code' => Hash::make($otp),
                'forgot_pass' => $hash,
            ]);

            $activation_link = 'https://whatspays.org/reset-password/' . urlencode($hash);
            $email_subject = get_email_subject('forgot-password', $name);

            // send email in queue
            $email_job = new SendEmail([
                'view' => 'email.forgot',
                'email' => $user_email,
                'subject' => $email_subject,
                'name' => $name,
                'activation_code' => $otp,
                'whatsapp_link' => $whatsapp_msg,
                'link' => $activation_link,
            ]);

            // dispatch job
            dispatch($email_job);

            $whatsapp_job = new WhatsAppJob([
                'to' => $whatsapp,
                'data' => [
                    'template_name' => 'forgot_password_final_v2',
                    'to' => (int) $whatsapp,
                    'name' => $name,
                    'code' => $otp,
                    'hash' => $hash,
                ],
            ]);

            dispatch($whatsapp_job);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Reset Password Process.
     *
     * @param $request
     *
     * @return $message
     */
    public function reset(Request $request)
    {
        try {
            // validate request
            $validator = Validator::make($request->input(), [
                'password' => 'required|confirmed|min:6',
                'activation_code' => 'required|string',
                'username' => ['required', 'string', function ($attribute, $value, $fail): void {
                    if (!filter_var($value, \FILTER_VALIDATE_EMAIL)) {
                        $value = (int) (str_replace(' ', '', $value));
                        if ($value <= 0) {
                            $fail('The ' . $attribute . ' is invalid.');
                        }
                    }
                }],
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $phone = (string) (int) Str::remove([' ', '-'], $request['username']);

            $user = $this->userRepository->findByColumnOr([
                'email' => $request['username'],
                'wp_num_inc_code' => $phone,
                'wp_num_exc_code' => $phone,
            ], [
                'id',
                'wp_num_inc_code',
                'name',
                'email',
                'activation_code',
            ]);

            // check activation code
            if (!$user || !Hash::check($request['activation_code'], $user->activation_code)) {
                throw new InvalidArgumentException(__('user.error.code'));
            }

            $this->resetPassword($user, $request['password']);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Reset password with Link.
     *
     * @param $request
     *
     * @return $message
     */
    public function resetWithLink($request)
    {
        try {
            // validate request
            $validator = Validator::make($request->input(), [
                'password' => 'required|confirmed|min:6',
                'password_confirmation' => 'required',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            // check hash key
            $user = $this->userRepository->findByColumnOr([
                'forgot_pass' => $request['resetHash'],
            ], [
                'id',
                'wp_num_inc_code',
                'name',
                'email',
            ]);

            if (!$user) {
                throw new InvalidArgumentException('Invalid reset key');
            }

            $this->resetPassword($user, $request['password']);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Change password process.
     *
     * @param $request
     *
     * @return $message
     */
    public function changePassword(Request $request)
    {
        // validate request
        try {
            $validator = Validator::make($request->input(), [
                'old_password' => 'required',
                'password' => 'required|confirmed|min:6',
                'password_confirmation' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }
            // check Old Password
            $user = $this->userRepository->findByColumn([
                'id' => Auth::user()->id,
            ], ['password']);

            if (!$user || !Hash::check($request['old_password'], $user->password)) {
                throw new InvalidArgumentException('Wrong Old Password');
            }

            $this->userRepository->update(Auth::user()->id, [
                'password' => bcrypt($request['new_password']),
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Deactivate user account.
     *
     * @param $request
     *
     * @return $message
     */
    public function deactivate()
    {
        try {
            $deactivated = $this->userRepository->update(Auth::user()->id, [
                'is_user_deactivated' => 1,
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $deactivated;
    }

    public function destroy($email)
    {
        try {
            $deleted = $this->userRepository->deleteByColumn([
                'email' => $email, ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $deleted;
    }

    /**
     * Update Profile.
     *
     * @param $request
     *
     * @return $message
     */
    public function ProfileUpdate(Request $request)
    {
        try {
            $whatsapp = extract_number_and_cc($request);
            $request['whatsapp'] = $whatsapp;
            $id = Auth::user()->id;
            $validator = Validator::make($request->input(), [
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email,' . $id,
                'country_code' => 'required',
                'whatsapp' => 'required|unique:users,wp_num_inc_code,' . $id,
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $user = $this->userRepository->updateGetModel([
                'id' => $id,
            ], [
                'name' => $request['name'],
                'email' => $request['email'],
                'country_code' => $request['country_code'],
                'wp_num_inc_code' => $whatsapp,
                'wp_num_exc_code' => $request['phone'],
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $user;
    }

    /**
     * Update Profile Image.
     *
     * @param $request
     *
     * @return $message
     */
    public function imageUpdate(Request $request)
    {
        try {
            $id = Auth::user()->id;
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            $user = $this->userRepository->findById($id, [
                'name',
            ]);

            $name = slugify($user->name);

            $without_ext = strtolower($name . '-' . time() . '-whatspays');
            $ext = $request->image->extension();
            $file_name = $without_ext . '.' . $ext;
            // $imageName = time().'.'.$request->image->extension();
            // $request->image->move(public_path('images'), $imageName);
            $request->image->storeAs('uploads/user/media', $file_name);

            $this->userRepository->updateByColumn([
                'id' => $id,
            ], [
                'image' => $file_name,
            ]);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param $user
     */
    public function checkUserStatus($user)
    {
        $result = $user;

        if (!$user->user_status) {
            throw new InvalidArgumentException(__('user.error.verified'));
        }

        if ($user->is_user_deactivated) {
            throw new InvalidArgumentException(__('user.error.deactivated'));
        }

        $result['auth_token'] = $user->createToken('whatstoken')->plainTextToken;

        $stores = $user->stores;

        // if user is company then add store id to tokens table
        if (('company' == $user->user_type || 'employee' == $user->user_type) && $stores->isNotEmpty()) {
            $token = explode('|', $result['auth_token']);

            $user->tokens()
                ->where(['id' => $token[0]])
                ->update(['store_id' => $stores[0]->pivot->store_id]);
        }

        $result['message'] = __('user.success.authenticated');

        return $result;
    }

    /**
     * reset password.
     *
     * @param $user
     * @param $password
     */
    public function resetPassword($user, $password): void
    {
        $this->userRepository->update($user->id, [
            'password' => bcrypt($password),
            'forgot_pass' => Hash::make(time() . $user->wp_num_inc_code . 'whatspays'),
            'activation_code' => Hash::make(generate_random_string()),
            'user_status' => 1,
        ]);

        // send email in queue
        $email_job = new SendEmail([
            'view' => 'email.reset',
            'email' => $user->email,
            'name' => $user->name,
            'subject' => get_email_subject('reset-password', $user->name),
            'link' => 'https://whatspays.org/forgot-password',
        ]);

        // dispatch job
        dispatch($email_job);
    }

    public function notificationview()
    {
        $user_id = Auth::id();

        return Notification::where('notifiable_id', $user_id)
            ->where('notifiable_type', 'App\Models\User')
            ->get();
    }
}

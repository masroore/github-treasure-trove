<?php

namespace App\Http\Controllers;

use App\Models\AccessHistory;
use App\Models\Country;
use App\Models\FailedLogin;
use App\Models\LoggedUser;
use App\Models\PasswordHistory;
use App\Models\Profile;
use App\Models\Storage;
use App\Models\SuspendedUser;
use App\Models\TelephoneOperator;
use App\Models\Theme;
use App\Models\TypeDocument;
use App\Models\User;
use App\Models\UserStorage;
use Browser;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $timeLogged = 40;

    private function kill_session(): void
    {
        if (Auth::check() == true) {
            $this->endLogin(Auth::user()->id);
        }
        session()->forget('currentModule');
        session()->flush();
        Auth::logout();
    }

    public function logout()
    {
        $this->kill_session();

        return Redirect::to('login');
    }

    public function end_login()
    {
        if (Auth::check() == true) {
            $this->endLogin(Auth::user()->id);
        }
        Auth::logout();

        return view('users.re_login');
    }

    public function extend_login()
    {
        session()->regenerate();

        $result['type'] = 'info';
        $result['status'] = 1;
        $result['message'] = __('Session extended');

        return $result;
    }

    public function login_modal(Request $request)
    {
        if (Auth::check() == false) {
            $Validator = \Validator::make(
                $request->all(),
                [
                    'username' => 'required',
                    'password' => 'required',
                ],
                [
                    'username.required' => __('Username is Required'),
                    'password.required' => __('Password is Required'),
                ]
            );

            if ($Validator->fails()) {
                $result['type'] = 'error';
                $result['status'] = 0;
                $result['message'] = __('Missing Required Fields');
                $result['reload'] = 0;
            } else {
                $User = User::where('username', $request->username)->first();

                if ($User == null) { // if user exists
                    $result['type'] = 'error';
                    $result['message'] = __('Wrong Data');
                    $result['status'] = 0;
                    $result['reload'] = 0;
                } else {
                    $is_logged = LoggedUser::where('user_id', $User->id)->first();
                    $continue = true;
                    if ($is_logged != null) {//if exists login
                        $now = Carbon::now();
                        $to = Carbon::createFromFormat('Y-m-d H:i:s', $is_logged->date_in);
                        $diff = $now->diffInMinutes($to);
                        if ($diff > $this->timeLogged) {
                            $AccessHistory = AccessHistory::where('user_id', $is_logged->user_id)->whereNull('date_out');
                            if ($AccessHistory != null) {
                                $AccessHistory->update(['date_out' => date('Y-m-d H:i:s')]);
                            }
                            $is_logged->delete();
                            $continue = true;
                        } else {
                            $continue = false;
                        }
                    }
                    if ($continue == true) {
                        if ($User->locked == 0) {// if user is blocked
                            if ($User->isSuspended() == false) {
                                $userdata = [
                                    'username' => $request->username,
                                    'password' => $request->password,
                                ];
                                if ($User->getProfile->status == true) {
                                    $where[] = ['user_id', $User->id];
                                    $where[] = ['ip', DB::raw("'" . $request->ip() . "'")];

                                    $begin_date = now();
                                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $begin_date);
                                    $date = $to->subMinutes(1);
                                    //$where[] = [DB::raw("'".$date."'"), 'BETWEEN' , DB::raw("date_in AND date_out")];

                                    $AccessHistory = AccessHistory::where($where)
                                        ->whereBetween(DB::raw("'" . $date . "'"), [DB::raw('date_in'), DB::raw('date_out')])
                                        ->first();
                                    if ($AccessHistory == null) {
                                        $result['type'] = 'error';
                                        $result['message'] = __('No Previous Session Detected');
                                        $result['status'] = 0;
                                        $result['reload'] = 1;
                                    } else {
                                        if (Auth::attempt($userdata)) {
                                            $LoggedUser = new LoggedUser();
                                            $LoggedUser->user_id = $User->id;
                                            $LoggedUser->date_in = now();
                                            $LoggedUser->platform = Browser::platformName();
                                            $LoggedUser->browser = Browser::browserName();
                                            $LoggedUser->browser_engine = Browser::browserEngine();
                                            $LoggedUser->ip = $request->ip();
                                            $LoggedUser->save();

                                            $AccessHistory = new AccessHistory();
                                            $AccessHistory->user_id = $User->id;
                                            $AccessHistory->date_in = now();
                                            $AccessHistory->ip = $request->ip();
                                            $AccessHistory->save();

                                            FailedLogin::where('user_id', $User->id)->whereDate('date_in', '=', date('Y-m-d'))->delete();

                                            $result['type'] = 'success';
                                            $result['message'] = __('User Logged In Correctly');
                                            $result['status'] = 1;
                                            $result['reload'] = 0;
                                        } else {
                                            $FailedLogin = new FailedLogin();
                                            $FailedLogin->user_id = $User->id;
                                            $FailedLogin->date_in = now();
                                            $FailedLogin->ip = $request->ip();
                                            $FailedLogin->save();

                                            if (FailedLogin::where('user_id', $User->id)->whereDate('date_in', '=', date('Y-m-d'))->count() >= 3) {
                                                //$User->update(['locked' => 1]);

                                                $begin_date = now();
                                                $to = Carbon::createFromFormat('Y-m-d H:i:s', $begin_date);
                                                $end_date = $to->addMinutes(30);

                                                $SuspendedUser = new SuspendedUser();

                                                $SuspendedUser->start_date = $begin_date;
                                                $SuspendedUser->end_date = $end_date;
                                                $SuspendedUser->ip = $request->ip();
                                                $SuspendedUser->user_suspended_id = $User->id;
                                                $SuspendedUser->user_id = $User->id;
                                                $SuspendedUser->save();

                                                $result['type'] = 'error';
                                                $result['message'] = __('User suspended for 30 Munitos');
                                                $result['status'] = 1;
                                                $result['reload'] = 1;
                                            } else {
                                                $result['type'] = 'error';
                                                $result['message'] = __('Wrong Data');
                                                $result['status'] = 0;
                                                $result['reload'] = 0;
                                            }
                                        }
                                    }
                                } else {
                                    $result['type'] = 'error';
                                    $result['message'] = __('inactive profile');
                                    $result['status'] = 0;
                                    $result['reload'] = 0;
                                }
                            } else {
                                $result['type'] = 'error';
                                $result['message'] = __('Disabled User');
                                $result['status'] = 0;
                                $result['reload'] = 1;
                            }
                        } else {
                            $result['type'] = 'error';
                            $result['message'] = __('User blocked');
                            $result['status'] = 0;
                            $result['reload'] = 1;
                        }
                    } else {
                        $result['type'] = 'error';
                        $result['message'] = __('has an active session');
                        $result['status'] = 0;
                        $result['reload'] = 1;
                    }
                }
            }
        } else {
            $result['type'] = 'error';
            $result['status'] = 0;
            $result['message'] = __('has an active session');
            $result['reload'] = 1;
        }

        return $result;
    }

    public function login(Request $request, $msg = '')
    {
        if (Auth::check() == false) {
            if ($request->isMethod('post')) {
                $Validator = \Validator::make(
                    $request->all(),
                    [
                        'username' => 'required',
                        'password' => 'required',
                    ],
                    [
                        'username.required' => __('Username is Required'),
                        'password.required' => __('Password is Required'),
                    ]
                );

                if ($Validator->fails()) {
                    $result['type'] = 'error';
                    $result['message'] = __('Missing Required Fields');
                } else {
                    $User = User::where('username', $request->username)->first();

                    if ($User == null) { // if user exists
                        $result['type'] = 'error';
                        $result['message'] = __('Wrong Data');
                    } else {
                        $is_logged = LoggedUser::where('user_id', $User->id)->first();
                        $continue = true;
                        if ($is_logged != null) {//if exists login
                            $now = Carbon::now();
                            $to = Carbon::createFromFormat('Y-m-d H:i:s', $is_logged->date_in);
                            $diff = $now->diffInMinutes($to);
                            if ($diff > 40) {
                                $AccessHistory = AccessHistory::where('user_id', $is_logged->user_id)->whereNull('date_out');
                                if ($AccessHistory != null) {
                                    $AccessHistory->update(['date_out' => date('Y-m-d H:i:s')]);
                                }
                                $is_logged->delete();
                                $continue = true;
                            } else {
                                $continue = false;
                            }
                        }
                        if ($continue == true) {
                            if ($User->locked == 0) {// if user is blocked
                                if ($User->isSuspended() == false) {
                                    $userdata = [
                                        'username' => $request->username,
                                        'password' => $request->password,
                                    ];
                                    if ($User->getProfile->status == true) {// IF PROFILE IS ACTIVE
                                        $lastDate = Carbon::createFromFormat('Y-m-d H:i:s', $User->getLastDateAccess());
                                        $now = Carbon::now();
                                        $days = $now->diffInDays($lastDate);
                                        if ($days < $this->timeForLockUsers) { // If the user has a long time without accessing the system

                                            if (Auth::attempt($userdata)) {
                                                $LoggedUser = new LoggedUser();
                                                $LoggedUser->user_id = $User->id;
                                                $LoggedUser->date_in = now();
                                                $LoggedUser->platform = Browser::platformName();
                                                $LoggedUser->browser = Browser::browserName();
                                                $LoggedUser->browser_engine = Browser::browserEngine();
                                                $LoggedUser->ip = $request->ip();
                                                $LoggedUser->save();

                                                $AccessHistory = new AccessHistory();
                                                $AccessHistory->user_id = $User->id;
                                                $AccessHistory->date_in = now();
                                                $AccessHistory->ip = $request->ip();
                                                $AccessHistory->save();

                                                FailedLogin::where('user_id', $User->id)->whereDate('date_in', '=', date('Y-m-d'))->delete();

                                                return Redirect::to('home');
                                            }
                                            $FailedLogin = new FailedLogin();
                                            $FailedLogin->user_id = $User->id;
                                            $FailedLogin->date_in = now();
                                            $FailedLogin->ip = $request->ip();
                                            $FailedLogin->save();

                                            if (FailedLogin::where('user_id', $User->id)->whereDate('date_in', '=', date('Y-m-d'))->count() >= 3) {
                                                //$User->update(['locked' => 1]);

                                                $begin_date = now();
                                                $to = Carbon::createFromFormat('Y-m-d H:i:s', $begin_date);
                                                $end_date = $to->addMinutes(30);

                                                $SuspendedUser = new SuspendedUser();

                                                $SuspendedUser->start_date = $begin_date;
                                                $SuspendedUser->end_date = $end_date;
                                                $SuspendedUser->ip = $request->ip();
                                                $SuspendedUser->user_suspended_id = $User->id;
                                                $SuspendedUser->user_id = $User->id;
                                                $SuspendedUser->save();

                                                $result['type'] = 'error';
                                                $result['message'] = __('User suspended for 30 Munitos');
                                            } else {
                                                $result['type'] = 'error';
                                                $result['message'] = __('Wrong Data');
                                            }
                                        } else {
                                            $User->locked = 1;
                                            $User->save();
                                            $result['type'] = 'error';
                                            $result['message'] = __('User blocked for many days of inactivity');
                                        }
                                    } else {
                                        $result['type'] = 'error';
                                        $result['message'] = __('inactive profile');
                                    }
                                } else {
                                    $result['type'] = 'error';
                                    $result['message'] = __('Suspended User');
                                }
                            } else {
                                $result['type'] = 'error';
                                $result['message'] = __('User blocked');
                            }
                        } else {
                            $result['type'] = 'error';
                            $result['message'] = __('has an active session');
                        }
                    }
                }

                return Redirect::to('login')->with('msg', $result);
            }

            return view('users.login');
        }

        return Redirect::to('home');
    }

    public function home()
    {
        $Menu = User::find(Auth::user()->id)->getMenu();

        return view('users.home', compact('Menu'));
    }

    public function change_password()
    {
        if (Auth::user()->change_password == 1) {
            return view('users.users_changePassword');
        }

        return Redirect::to('home');
    }

    public function password_update(Request $request)
    {
        $messages = [
            'password.required' => __('Password is Required'),
            'password.min' => __('Invalid password min length'),
            'password.max' => __('Invalid password max length'),
            'password.regex' => __('The password format is invalid'),
            'password_confirmation.required' => __('Password confirmation Required'),
        ];

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|max:15|confirmed|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[~!@#$%^&*-_.+=?><]).*$/',
            'password_confirmation' => 'required',
        ], $messages);

        if ($validator->fails()) {
            $result['status'] = 0;
            $result['title'] = __('Password');
            $result['message'] = '';
            foreach ($validator->errors()->all() as $key => $value) {
                $result['message'] .= $value . '<br/>';
            }
            $result['data'] = null;
            $result['type_message'] = 'error';
        } else {
            DB::table('password_histories')->where('user_id', Auth::user()->id)->where('end_date', null)->update(['end_date' => date('Y-m-d H-i-s')]);
            $history_pass = PasswordHistory::where('user_id', Auth::user()->id)->limit(5)->get()->toArray();
            $pass = false;
            for ($i = 0; $i < count($history_pass) && $pass == false; ++$i) {
                $pass = Hash::check($request->password, $history_pass[$i]['password']);
            }
            if ($pass == true) {
                $result['status'] = 0;
                $result['title'] = __('Change Password');
                $result['message'] = __('Password already exists');
                $result['type_message'] = 'error';
            } else {
                try {
                    $item = User::find(Auth::user()->id);
                    if ($item != null) {
                        $item->password = Hash::make($request->password);
                        $item->change_password = 0;
                        $item->save();

                        $history_pass = PasswordHistory::where('user_id', Auth::user()->id)->limit(5)->get()->toArray();
                        if (count($history_pass) == 5) {
                            $history_pass = PasswordHistory::where('user_id', Auth::user()->id)->first()->delete();
                        }
                        $password_history = new PasswordHistory();
                        $password_history->password = Hash::make($request->password);
                        $password_history->start_date = date('Y-m-d H-i-s');
                        $password_history->end_date = null;
                        $password_history->user_id = Auth::user()->id;

                        $password_history->save();

                        $logout = LoggedUser::where('user_id', Auth::user()->id)->first()->delete();

                        $result['status'] = 1;
                        $result['title'] = __('Change Password');
                        $result['message'] = __('Password Updated');
                        $result['type_message'] = 'success';
                    } else {
                        $result['status'] = 0;
                        $result['title'] = __('Change Password');
                        $result['message'] = __('User not found');
                        $result['type_message'] = 'error';
                    }
                } catch (Exception $e) {
                    $result['status'] = 0;
                    $result['title'] = __('Change Password');
                    $result['message'] = $e->getMessage();
                    $result['type_message'] = 'error';
                }
            }
        }

        return $result;
    }

    public function access_history(Request $request)
    {
        if (\Request::ajax()) {
            //dd($request->all());
            $Users = $this->getSelectListUsers();
            $History = [];
            if ($request->isMethod('post')) {
                $where[] = [DB::raw('1'), '1'];

                if ($request->user_id != null) {
                    $where[] = ['users.id', $request->user_id];
                }
                if ($request->date_in != null && $request->date_out != null) {
                    $Validator = \Validator::make(
                        $request->all(),
                        [
                            'date_in' => 'date',
                            'date_out' => 'date',
                        ]
                    );
                    if (!$Validator->fails()) {
                        $where[] = [DB::raw('COALESCE(cast(access_histories.date_out as date), current_date)'), '>=', $this->saveDate($request->date_in)];
                        $where[] = [DB::raw('cast(access_histories.date_in as date)'), '<=', $this->saveDate($request->date_out)];
                    }
                }
                //dd( $where);
                $History = User::join('type_documents', 'type_documents.id', '=', 'users.type_document_id')
                    ->join('access_histories', 'access_histories.user_id', '=', 'users.id')
                    ->select('users.id', 'access_histories.id as h_id', DB::raw("CONCAT(type_documents.abbreviation,'-', users.document, ' ' ,users.name_user, ' ',users.surname_user ) as full_name"), 'access_histories.date_in', DB::raw('COALESCE(access_histories.date_out, now()) as date_out'), 'access_histories.ip')
                    ->where($where)
                    ->orderBy('access_histories.id', 'DESC')
                    ->get()->toArray();
                //->toSql();
                //dd($History);
            }

            return view('users.access_history', compact('Users', 'History'));
        }

        return Redirect::to('home');
    }

    public function index_logged_users()
    {
        if (\Request::ajax()) {
            $logged = User::query()
                ->join('type_documents', 'type_documents.id', '=', 'users.type_document_id')
                ->join('logged_users', 'logged_users.user_id', '=', 'users.id')
                ->select('users.id', DB::raw("CONCAT(type_documents.abbreviation,'-', users.document, ' ' ,users.name_user, ' ',users.surname_user ) as full_name"), 'logged_users.date_in', 'logged_users.ip')
                ->where('logged_users.user_id', '!=', Auth::user()->id)
                ->get()->toArray();

            return view('users.logged_users', compact('logged'));
        }

        return Redirect::to('home');
    }

    public function delete_logged($id)
    {
        if (\Request::ajax()) {
            try {
                DB::table('logged_users')
                    ->where('user_id', $id)
                    ->delete();

                $result['status'] = 1;
                $result['title'] = __('Users');
                $result['message'] = __('Deleted');
                $result['type_message'] = 'success';
                $result['redirect'] = route('logged_users');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Users');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = route('logged_users');
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function restricted_access(Request $request)
    {
        if (\Request::ajax()) {
            $Users = $this->getSelectListUsers();
            $History = [];
            if ($request->isMethod('post')) {
                $History = User::query()
                    ->join('type_documents', 'type_documents.id', '=', 'users.type_document_id')
                    ->join('restricted_accesses', 'restricted_accesses.user_id', '=', 'users.id')
                    ->join('processes', 'processes.id', '=', 'restricted_accesses.process_id');

                if ($request->user_id != null) {
                    $History = $History->where('users.id', '=', $request->user_id);
                }

                if ($request->date_in != null && $request->date_out != null) {
                    $Validator = \Validator::make(
                        $request->all(),
                        [
                            'date_in' => 'required',
                            'date_out' => 'required',
                        ]
                    );
                    if (!$Validator->fails()) {
                        $History = $History->whereDate('restricted_accesses.date_in', '>=', $this->saveDate($request->date_in));
                        $History = $History->whereDate('restricted_accesses.date_in', '<=', $this->saveDate($request->date_out));
                    }
                }
                $History = $History->orderBy('restricted_accesses.date_in', 'DESC')
                    ->select('users.id', DB::raw("CONCAT(type_documents.abbreviation,'-', users.document, ' ' ,users.name_user, ' ',users.surname_user ) as full_name"), 'restricted_accesses.date_in', 'restricted_accesses.ip', 'processes.name_process')
                    ->get()->toArray();
            }

            return view('users.restricted_access', compact('Users', 'History'));
        }

        return Redirect::to('home');
    }

    public function theme($theme = 1): void
    {
        $theme = Theme::find($theme);
        $user = User::find(Auth::user()->id);
        $user->theme_id = $theme->id;
        $user->save();
        session()->put('theme', $theme->class_name);
    }

    public function failed_login(Request $request)
    {
        if (\Request::ajax()) {
            $Users = $this->getSelectListUsers();
            $History = User::query()
                ->join('type_documents', 'type_documents.id', '=', 'users.type_document_id')
                ->join('failed_logins', 'failed_logins.user_id', '=', 'users.id');
            if ($request->isMethod('post')) {
                if ($request->user_id != null) {
                    $History = $History->where('users.id', '=', $request->user_id);
                }

                if ($request->date_in != null && $request->date_out != null) {
                    $Validator = \Validator::make(
                        $request->all(),
                        [
                            'date_in' => 'required',
                            'date_out' => 'required',
                        ]
                    );
                    if (!$Validator->fails()) {
                        $History = $History->whereDate('failed_logins.date_in', '>=', $this->saveDate($request->date_in));
                        $History = $History->whereDate('failed_logins.date_in', '<=', $this->saveDate($request->date_out));
                    }
                }
            }
            $History = $History->orderBy('failed_logins.date_in', 'DESC')
                ->select('users.id', DB::raw("CONCAT(type_documents.abbreviation,'-', users.document, ' ' ,users.name_user, ' ',users.surname_user ) as full_name"), 'failed_logins.date_in', 'failed_logins.ip')
                ->take(100)
                ->get()->toArray();

            return view('users.failed_login', compact('Users', 'History'));
        }

        return Redirect::to('home');
    }

    public function index()
    {
        if (\Request::ajax()) {
            $users = User::all()->toArray();
            // $users = User::find(10)->getSuspensions;
            return view('users.users', compact('users'));
        }

        return Redirect::to('home');
    }

    public function create()
    {
        if (\Request::ajax()) {
            $path_file = $this->getPathTimer();
            $myfile = fopen($path_file, 'rb');
            $timer = json_decode(fread($myfile, filesize($path_file)));

            $country = Country::pluck('code_phone', 'id');
            $operator = TelephoneOperator::pluck('code', 'id');
            $profile = Profile::pluck('name_profile', 'id');
            $document_type = TypeDocument::where('type_client_id', '=', $this->PersonNatural)->pluck('abbreviation', 'id');
            $storage = Storage::pluck('name_storage', 'id');

            return view('users.users_create', compact('country', 'operator', 'profile', 'document_type', 'storage', 'timer'));
        }

        return Redirect::to('home');
    }

    public function store(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'name_user.required' => __('Name is Required'),
                'surname_user.required' => __('Surname is Required'),
                'document.required' => __('Document is Required'),
                'document.unique' => __('Document already exists'),
                'document.max' => __('length of maximum unsupported for document'),
                'phone.required' => __('Phone number is Required'),
                'phone.max' => __('length of maximum unsupported for phone'),
                'phone.min' => __('length of minimum unsupported for phone'),
                'email.required' => __('E-mail is Required'),
                'email.unique' => __('E-mail already exists'),
                'document_type.required' => __('Document type is Required'),
                'operator.required' => __('Phone operator is Required'),
                'profile.required' => __('Profile operator is Required'),
                'storage.required' => __('Storage is Required'),
                'avatar.required' => __('Avatar is Required'),
            ];
            $rules = [
                'name_user' => 'required',
                'surname_user' => 'required',
                'document' => 'required|max:8|unique:users,document,' . $request->id,
                'phone' => 'required|min:7|max:7',
                'email' => 'required|unique:users,email,' . $request->id,
                'document_type' => 'required',
                'operator' => 'required',
                'profile' => 'required',
                'storage' => 'required',
                'avatar' => 'required',
            ];

            if (Auth::user()->special_permission == 1) {
                $rules['time_inactivity'] = 'required|min:3|gt:179';
                $messages['time_inactivity.required'] = __('Time of Inactivity is Required');
                $messages['time_inactivity.min'] = __('Incorrect idle time minimum value length');
                $messages['time_inactivity.gt'] = __('The idle time value must be 180 or greater');
            }

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('Users');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = route('users');

                return $result;
            }

            try {
                //dd( $request->storage);
                $name = substr(strtolower(explode(' ', trim($this->setClearString($request->name_user)))[0]), 0, 1);
                $surname = strtolower((explode(' ', trim($this->setClearString($request->surname_user)))[0]));
                $username = $name . $surname;

                $username = $this->getNameUser($username);

                $path_file = $this->getPathTimer();
                $myfile = fopen($path_file, 'rb');
                $timer = json_decode(fread($myfile, filesize($path_file)));

                $link = URL('/logout');
                $random = Str::random(6);
                $item = new User();
                $item->name_user = $request->name_user;
                $item->surname_user = $request->surname_user;
                $item->username = $username;
                $item->password = Hash::make($random);
                $item->document = $request->document;
                $item->phone = $request->phone;
                $item->email = $request->email;
                $item->special_permission = isset($request->special_permission[null]) ? 1 : 0;
                $item->sensitive_info = isset($request->sensitive_info[null]) ? 1 : 0;
                $item->change_password = 1;
                $item->locked = 0;
                if (Auth::user()->special_permission == 1) {
                    $item->time_inactivity = $request->time_inactivity;
                } else {
                    $item->time_inactivity = $timer->timer;
                }
                $item->avatar = $request->avatar;
                $item->type_document_id = $request->document_type;
                $item->telephone_operator_id = $request->operator;
                $item->profile_id = $request->profile;
                $item->theme_id = 1;
                $item->user_id = Auth::user()->id;
                $item->date_register = date('Y-m-d H-i-s');
                $item->ip = $request->ip();
                $item->save();

                $item_id = $item->id;

                foreach ($request->storage as $value) {
                    $item2 = new UserStorage();
                    $item2->user_id = $item_id;
                    $item2->storage_id = $value;
                    $item2->save();
                }

                $info_mail = ['link' => $link, 'username' => $item->username, 'name' => $item->name_user . ' ' . $item->surname_user, 'password' => $random];
                $this->send_mail($request->email, 'users.users_mail', $info_mail);

                $result['status'] = 1;
                $result['title'] = __('Users');
                $result['message'] = __('Stored');
                $result['type_message'] = 'success';
                $result['redirect'] = route('users');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Users');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = route('users');
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function edit($id)
    {
        if (\Request::ajax()) {
            $path_file = $this->getPathTimer();
            $myfile = fopen($path_file, 'rb');
            $timer = json_decode(fread($myfile, filesize($path_file)));

            $item = User::find($id)->toArray();
            $item2 = UserStorage::where('user_id', $id)->get()->toArray();
            $item_storage = [];
            foreach ($item2 as $value) {
                $item_storage[] = $value['storage_id'];
            }

            $operator = TelephoneOperator::pluck('code', 'id');
            $profile = Profile::pluck('name_profile', 'id');
            $document_type = TypeDocument::where('type_client_id', '=', $this->PersonNatural)->pluck('abbreviation', 'id');
            $storage = Storage::pluck('name_storage', 'id');

            return view('users.users_edit', compact('item', 'operator', 'profile', 'document_type', 'storage', 'item_storage', 'timer'));
        }

        return Redirect::to('home');
    }

    public function update(Request $request, User $user)
    {
        if (\Request::ajax()) {
            $messages = [
                'name_user.required' => __('Name is Required'),
                'surname_user.required' => __('Surname is Required'),
                'document.required' => __('Document is Required'),
                'document.unique' => __('Document already exists'),
                'document.max' => __('length of maximum unsupported for document'),
                'phone.required' => __('Phone number is Required'),
                'phone.max' => __('length of maximum unsupported for phone'),
                'phone.min' => __('length of minimum unsupported for phone'),
                'email.required' => __('E-mail is Required'),
                'email.unique' => __('E-mail already exists'),
                'document_type.required' => __('Document type is Required'),
                'operator.required' => __('Phone operator is Required'),
                'profile.required' => __('Profile operator is Required'),
                'storage.required' => __('Storage is Required'),
                'avatar.required' => __('Avatar is Required'),
            ];
            $rules = [
                'name_user' => 'required',
                'surname_user' => 'required',
                'document' => 'required|max:8|unique:users,document,' . $request->id,
                'phone' => 'required|min:7|max:7',
                'email' => 'required|unique:users,email,' . $request->id,
                'document_type' => 'required',
                'operator' => 'required',
                'profile' => 'required',
                'storage' => 'required',
                'avatar' => 'required',
            ];

            if (Auth::user()->special_permission == 1) {
                $rules['time_inactivity'] = 'required|min:3|gt:179';
                $messages['time_inactivity.required'] = __('Time of Inactivity is Required');
                $messages['time_inactivity.min'] = __('Incorrect idle time minimum value length');
                $messages['time_inactivity.gt'] = __('The idle time value must be 180 or greater');
            }

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('Users');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';
                $result['redirect'] = route('users');

                return $result;
            }

            try {
                $item = User::find($request->id);
                if ($item != null) {
                    $path_file = $this->getPathTimer();
                    $myfile = fopen($path_file, 'rb');
                    $timer = json_decode(fread($myfile, filesize($path_file)));

                    $item->name_user = $request->name_user;
                    $item->surname_user = $request->surname_user;
                    $item->document = $request->document;
                    $item->phone = $request->phone;
                    $item->email = $request->email;
                    $item->special_permission = isset($request->special_permission[null]) ? 1 : 0;
                    $item->sensitive_info = isset($request->sensitive_info[null]) ? 1 : 0;
                    if (Auth::user()->special_permission == 1) {
                        $item->time_inactivity = $request->time_inactivity;
                    } else {
                        $item->time_inactivity = $timer->timer;
                    }
                    $item->avatar = $request->avatar;
                    $item->type_document_id = $request->document_type;
                    $item->telephone_operator_id = $request->operator;
                    $item->profile_id = $request->profile;
                    $item->user_id = Auth::user()->id;
                    $item->date_register = date('Y-m-d H-i-s');
                    $item->ip = $request->ip();
                    $item->save();

                    $item_id = $item->id;
                    $item2 = UserStorage::where('user_id', $item_id)->delete();

                    foreach ($request->storage as $value) {
                        $item2 = new UserStorage();
                        $item2->user_id = $item_id;
                        $item2->storage_id = $value;
                        $item2->save();
                    }

                    /*
                    $item2 = new UserStorage();
                    $item2->user_id = $item_id;
                    $item2->storage_id = $request->storage;
                    $item2->save();
                    */
                    $result['status'] = 1;
                    $result['title'] = __('Users');
                    $result['message'] = __('User: ') . $item->username . __(' has been updated');
                    $result['type_message'] = 'success';
                    $result['redirect'] = route('users');
                } else {
                    $result['status'] = 0;
                    $result['title'] = __('Users');
                    $result['message'] = __('No data found');
                    $result['type_message'] = 'info';
                    $result['redirect'] = route('users');
                }
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Users');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = route('users');
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function show_modal($id)
    {
        if (\Request::ajax()) {
            $item = User::find($id);

            return view('users.lock_users', compact('item'));
        }

        return Redirect::to('home');
    }

    public function susp_user($id, $date_in, $date_out)
    {
        if (\Request::ajax()) {
            $messages = [
                'date_in.required' => __('Date start required'),
                'date_out.required' => __('Date end required'),
                //'date_out.after'              => __('The end date must be after the start date'),
            ];

            $data = [
                'date_in' => $date_in,
                'date_out' => $date_out,
            ];

            $validator = Validator::make($data, [
                'date_in' => 'required',
                'date_out' => 'required',
            ], $messages);

            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('User');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';

                return $result;
            }

            try {
                $item = new SuspendedUser();
                $item->start_date = $date_in . ' 01:00:00';
                $item->end_date = $date_out . ' 23:59:00';
                $item->user_suspended_id = $id;
                $item->user_id = Auth::user()->id;
                $item->ip = \Request::ip();
                $item->save();

                $result['status'] = 1;
                $result['title'] = __('Users');
                $result['message'] = __('User suspended');
                $result['type_message'] = 'success';
                $result['redirect'] = route('users');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Users');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = route('users');
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function lock_user($id)
    {
        if (\Request::ajax()) {
            try {
                $item = User::find($id);
                $item->locked = 1;
                $item->save();

                $result['status'] = 1;
                $result['title'] = __('Users');
                $result['message'] = __('User: ') . $item->username . __(' Locked');
                $result['type_message'] = 'success';
                $result['redirect'] = route('users');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Users');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = route('users');
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function unlock_user($id)
    {
        if (\Request::ajax()) {
            try {
                $item = User::find($id);
                $item->locked = 0;
                $item->save();

                $result['status'] = 1;
                $result['title'] = __('Users');
                $result['message'] = __('User: ') . $item->username . __(' Unlocked');
                $result['type_message'] = 'success';
                $result['redirect'] = route('users');
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Users');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = route('users');
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function reset_password($id)
    {
        if (\Request::ajax()) {
            try {
                $item = User::find($id);

                if ($item != null) {
                    $link = URL('/logout');
                    $random = Str::random(6);
                    $item->password = Hash::make($random);
                    $item->change_password = 1;
                    $item->save();

                    $info_mail = ['link' => $link, 'username' => $item->username, 'name' => $item->name_user . ' ' . $item->surname_user, 'password' => $random];
                    $this->send_mail($item->email, 'users.users_resetPassword_mail', $info_mail);

                    $logout = LoggedUser::where('user_id', $id)->get();
                    if (count($logout) > 0) {
                        $logout = LoggedUser::where('user_id', $id)->first()->delete();
                    }

                    $result['status'] = 1;
                    $result['title'] = __('Users');
                    $result['message'] = __('User: ') . $item->username . __(' password has been reset');
                    $result['type_message'] = 'success';
                    $result['redirect'] = route('users');
                } else {
                    $result['status'] = 0;
                    $result['title'] = __('Users');
                    $result['message'] = __('No data found');
                    $result['type_message'] = 'info';
                    $result['redirect'] = route('users');
                }
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Users');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = route('users');
            }

            return $result;
        }

        return Redirect::to('home');
    }

    // TIME INACTIVITY

    public function index_time_inactivity()
    {
        if (\Request::ajax()) {
            $path_file = $this->getPathTimer();
            $myfile = fopen($path_file, 'rb');
            $timer = json_decode(fread($myfile, filesize($path_file)));

            return view('users.time_inactivity', compact('timer'));
        }

        return Redirect::to('home');
    }

    public function createTimeInactivity(Request $request)
    {
        if (\Request::ajax()) {
            $messages = [
                'inactivity_time.required' => __('Time of Inactivity is Required'),
                'inactivity_time.min' => __('Incorrect idle time minimum value length'),
                'inactivity_time.gt' => __('The idle time value must be 180 or greater'),
            ];

            $validator = Validator::make($request->all(), [
                'inactivity_time' => 'required|min:3|gt:179',
            ], $messages);

            if ($validator->fails()) {
                $result['status'] = 0;
                $result['title'] = __('Time Inactivity');
                $result['message'] = '';
                foreach ($validator->errors()->all() as $key => $value) {
                    $result['message'] .= $value . '<br/>';
                }
                $result['data'] = null;
                $result['type_message'] = 'error';

                return $result;
            }

            try {
                $path_file = $this->getPathTimer();

                if (!file_exists($path_file)) {
                    $myfile = fopen($path_file, 'wb');
                    fwrite($myfile, '');
                }
                $myfile = fopen($path_file, 'wb');

                $txt = '{"timer":' . $request->inactivity_time . '}';
                fwrite($myfile, $txt);

                $result['status'] = 1;
                $result['title'] = __('Time Inactivity');
                $result['message'] = __('Successfully Stored');
                $result['type_message'] = 'success';
                $result['redirect'] = '';
            } catch (Exception $e) {
                $result['status'] = 0;
                $result['title'] = __('Time Inactivity');
                $result['message'] = $e->getMessage();
                $result['type_message'] = 'error';
                $result['redirect'] = '';
            }

            return $result;
        }

        return Redirect::to('home');
    }

    public function removeSus($id)
    {
        if (\Request::ajax()) {
            $suspen = SuspendedUser::where('user_suspended_id', $id)->delete();
            $result['status'] = 1;
            $result['title'] = __('');
            $result['message'] = __('Successfully update');
            $result['type_message'] = 'success';
            $result['redirect'] = '';

            return $result;
        }

        return Redirect::to('home');
    }
}

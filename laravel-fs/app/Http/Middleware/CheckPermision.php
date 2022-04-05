<?php

namespace App\Http\Middleware;

use App\Mail\RestrictedAccessMail;
use App\Models\LoggedUser;
use App\Models\Process;
use App\Models\RestrictedAccess;
use App\Models\User;
use Browser;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

use Request;
use Session;

class CheckPermision
{
    /**
     * List of routes without login.
     */
    protected $routesFree = ['home', 'theme', 'get_account'];

    protected $exceptions = ['users.change_password', 'users.password_update'];

    protected $timeForChangePassw = 90;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->locked == 0) { // if not is blocked
            $User = User::find(Auth::user()->id);
            if ($User->isSuspended() == false) { //if not is suspended

                $position_point = strpos(Request::route()->getName(), '.');
                if ($position_point === false) {
                    $nameRoute = Request::route()->getName();
                } else {
                    $nameRoute = explode('.', Request::route()->getName());
                    $nameRoute = $nameRoute[0];
                }

                $LoggedUser = LoggedUser::where('user_id', Auth::user()->id)->first();
                if ($LoggedUser != null) {  // if exists on table logged_user

                    $security = $LoggedUser->platform == Browser::platformName() &&
                        $LoggedUser->browser == Browser::browserName() &&
                        $LoggedUser->browser_engine == Browser::browserEngine() &&
                        $LoggedUser->ip == $request->ip();
                    if ($security == true) {
                        $Process = Process::where('route', $nameRoute)->first();

                        if (!in_array($nameRoute, $this->routesFree)) {// if require permission

                            if ($Process != null) {
                                $has_permision = in_array($nameRoute, $User->getProfile->getProcesses->pluck('route')->toArray()); // if has permision
                                $is_exemption = in_array(Request::route()->getName(), $this->exceptions); // if is  exemption
                                if ($has_permision || $is_exemption) {
                                    if ($Process->special_permission == 1) { // if module require special permission
                                        if (Auth::user()->special_permission == 1) { // if user has special permission
                                            Session::put('currentModule', $nameRoute);

                                            return $next($request);
                                        }
                                        $RestrictedAccess = new RestrictedAccess();
                                        $RestrictedAccess->user_id = Auth::user()->id;
                                        $RestrictedAccess->process_id = $Process->id;
                                        $RestrictedAccess->date_in = now();
                                        $RestrictedAccess->ip = $request->ip();
                                        $RestrictedAccess->save();

                                        $info_mail = ['username' => Auth::user()->username, 'name' => Auth::user()->name_user . ' ' . Auth::user()->surname_user, 'date' => date('Y-m-d'), 'time' => date('H:i:s')];

                                        $this->send_mail(Auth::user()->email, 'users.users_restrictedAccess_mail', $info_mail);

                                        return redirect('/home');
                                    }
                                    Session::put('currentModule', $nameRoute);

                                    return $next($request);
                                }
                                $RestrictedAccess = new RestrictedAccess();
                                $RestrictedAccess->user_id = Auth::user()->id;
                                $RestrictedAccess->process_id = $Process->id;
                                $RestrictedAccess->date_in = now();
                                $RestrictedAccess->ip = $request->ip();
                                $RestrictedAccess->save();

                                $info_mail = ['username' => Auth::user()->username, 'name' => Auth::user()->name_user . ' ' . Auth::user()->surname_user, 'date' => date('Y-m-d'), 'time' => date('H:i:s')];

                                $this->send_mail(Auth::user()->email, 'users.users_restrictedAccess_mail', $info_mail);

                                if ($request->expectsJson()) {
                                    $result['status'] = -1;
                                    $result['title'] = __('');
                                    $result['message'] = __('Permission Denied');
                                    $result['data'] = null;
                                    $result['type_message'] = 'error';
                                    $result['redirect'] = '';

                                    return response()->json($result, 200);
                                }

                                return redirect()->route('errors.permission_denied');
                            }
                            dd('Modulo no Registrado');
                        } else {
                            $lastDatePwd = Carbon::createFromFormat('Y-m-d H:i:s', $User->getLastDatePassword());
                            $now = Carbon::now();
                            $days = $now->diffInDays($lastDatePwd);

                            if ($days >= $this->timeForChangePassw) { //If the user has to change the password
                                $item = User::find(Auth::user()->id);
                                $item->change_password = 1;
                                $item->save();

                                return Redirect::to('U0001.change_password')->withInput(null);
                            }
                            if (Auth::user()->change_password == 1) {
                                return Redirect::to('U0001.change_password');
                            }

                            return $next($request);
                        }
                    } else {
                        return redirect('/logout');
                    }
                } else {
                    $return = __('Your session has been restarted');
                }
            } else {
                $return = __('Your user has been Suspended');
            }
        } else {
            $return = __('Your user has been Blocked');
        }
        if ($request->expectsJson()) {
            $result['status'] = -1;
            $result['title'] = __('');
            $result['message'] = $return;
            $result['data'] = null;
            $result['type_message'] = 'error';
            $result['redirect'] = '';
        } else {
            return redirect('/logout');
        }
    }

    public function send_mail($mail_to, $template, $info_mail): void
    {
        $data['info_mail'] = $info_mail;
        $data['template'] = $template;
        Mail::to($mail_to)->send(new RestrictedAccessMail($data));
    }
}

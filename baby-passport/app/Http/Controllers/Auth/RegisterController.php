<?php

namespace App\Http\Controllers\Auth;

use App\Events\MomEvent;
use App\Http\Controllers\Controller;
use App\Mail\SendUser;
use App\Models\Notification;
use App\Models\User;
use App\Traits\LogTrait;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;
use Storage;
use Swift_TransportException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use LogTrait;
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    public function register(Request $request)
    {
        try {
            $this->validator($request->all())->validate();

            event(new Registered($user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'address' => $request['address'] ?? null,
                'type' => $request['type'],
                'password' => Hash::make($request['password']),
            ])));

            $successText = $request['type'] == 'pacient' ? 'Tu cuenta ha sido creada correctamente' : 'En breve analizaremos tus datos para activar tu cuenta';
            $request->session()->flash('success', $successText);

            Mail::send(new SendUser([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => $request['password'],
            ]));

            $notification = [
                'description' => 'Se ha registrado el usuario ' . $request['name'],
                'url' => route('users.profile', [$user->id]),
                'user_id' => null,
                'receiver' => 'superadmin',
            ];

            $notification = Notification::create($notification);

            event(new MomEvent([
                'id' => $notification->id,
                'url' => $notification->url,
                'description' => $notification->description,
                'date' => $notification->created_at->format('d F Y h:i a'),
            ]));

            Storage::makeDirectory('public/moms/' . $user->id);

            Auth::loginUsingId($user->id);
            $redirectTo = $request['type'] == 'pacient' ? route('web.getMomProfile', [Auth::user()->id]) : route('web.getDoctorProfile');

            return $this->registered($request, $user)
                ?: redirect($redirectTo);
        } catch (Swift_TransportException $e) {
            $log = $this->saveLog($e->getMessage(), $e->getCode(), 'server');
            $request->session()->flash('error', 'Hubo un error al crear su registro, consulte a uno de nuestros agentes');

            return back()
                ->with(['userType' => $request['type']])
                ->withInput();
        } catch (QueryException $e) {
            $log = $this->saveLog($e->getMessage(), $e->getCode(), 'database');
            $request->session()->flash('error', 'Hubo un error al crear su registro, consulte a uno de nuestros agentes');

            return back()
                ->with(['userType' => $request['type']])
                ->withInput();
        }
    }
}

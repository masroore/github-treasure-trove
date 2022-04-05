<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TreeController;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;

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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::USER_PROFILE;

    public $treeController;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->treeController = new TreeController();

        $this->middleware('guest');
        // Permite obtener la informacion de los paises
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        try {
            return Validator::make($data, [
                'fullname' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                // 'term' => ['required']
            ]);
        } catch (Throwable $th) {
            // dd($th);
            //throw $th;
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\User
     */
    protected function create(array $data)
    {
        try {
            $whatsapp = '-----';
            $binary_side = '';
            $binary_id = 0;
            if (!empty($data['referred_id'])) {
                $userR = User::find($data['referred_id']);
                $binary_id = $this->treeController->getPosition($data['referred_id'], $userR->binary_side_register);
                $binary_side = $userR->binary_side_register;
            }
            $user = User::create([
                // 'name' => $fullname[0],
                // 'last_name' => (!empty($fullname[1])) ? $fullname[1] : '',
                'fullname' => $data['fullname'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'whatsapp' => $whatsapp,
                'referred_id' => $data['referred_id'],
                'binary_id' => $binary_id,
                'binary_side' => $binary_side,
            ]);

            $encritado = Crypt::encryptString($user->id);
            $ruta = route('checkemail', $encritado);

            Mail::send('mail.checkEmail', ['ruta' => $ruta, 'username' => $data['username']], function ($message) use ($user): void {
                $message->subject('Bienvenido a Legazy Pro');
                $message->to($user->email);
            });

            return $user;
        } catch (Throwable $th) {
            dd($th);
            // throw $th;
        }
    }
}

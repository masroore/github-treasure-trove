<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Contact\Repositories\ContactRepositoriesInterface;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $userRepository;

    /**
     * @var ContactRepositoriesInterface
     */
    private $contactRepositories;

    /**
     * Create a new controller instance.
     */
    public function __construct(ContactRepositoriesInterface $contactRepositories)
    {
        $this->middleware('guest');
        $this->contactRepositories = $contactRepositories;
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

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\User
     */
    protected function create(array $data)
    {
        $contact = $this->contactRepositories->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['email'],
            'contact_type' => $data['contact_type'],
            'password' => $data['password'],
        ]);

        return $contact->user;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        abort_if((!app('business_settings')->where('type', 'system_registration')->first()->status || !app('general_setting')->first()->contact_login), 404);

        return view('auth.register');
    }

    /**
     * The user has been registered.
     *
     * @param  mixed  $user
     *
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        return response()->json(['message' => trans('auth.registration_complete'), 'goto' => redirect()->intended($this->redirectPath())->getTargetUrl()]);
    }
}

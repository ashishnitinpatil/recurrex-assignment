<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'mobile' => 'required|max:10',
            'email' => 'required|email|max:255|unique:users',
            'profile_pic' => 'max:2083',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAdminRegistrationForm()
    {
        return view('auth.register')->with('forAdmin', true);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerAdmin(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        Auth::guard($this->getGuard())->login($this->create($request->all(), true));

        return redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data, $asAdmin=false)
    {
        if (!isset($data['name']) && isset($data['first_name']) && isset($data['last_name']))
            $data['name'] = trim($data['first_name']) . ' ' . trim($data['last_name']);
        if (empty($data['profile_pic']))
            $data['profile_pic'] = User::DEFAULT_PROFILE_PIC;

        $user = User::create([
            'name' => $data['name'],
            'first_name' => trim($data['first_name']),
            'last_name' => trim($data['last_name']),
            'mobile' => $data['mobile'],
            'profile_pic' => $data['profile_pic'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        if ($asAdmin) {
            $user->is_admin = true;
            $user->save();
        }

        return $user;
    }
}

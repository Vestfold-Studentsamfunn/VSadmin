<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Auth;
use Input;
use Validator;
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
	protected $redirectTo = '/dashboard';
    protected $redirectAfterLogout = '/';

    /**
     * Create a new authentication controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['/', 'getLogin', 'postLogin']]);
    }

    public function getRegister(){
        return view('auth.register');
    }

    public function postRegister(Validator $request)
    {
		dd($request);
        $this->create($request);
        flash('Brukeren ble opprettet');
        return back();
    }

    public function getProfile(){

        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    public function postProfile()
    {
        if (Input::has('id')) {
            $user = User::find(Input::get('id'));
        }
        else {
            $user = User::find(Auth::user()->id);
        }

        $user->first_name = Input::get('first_name');
        $user->last_name = Input::get('last_name');
        $user->email = Input::get('email');

        if (Input::has('password')) {
            if (Input::get('password') === Input::get('password_confirmation')){
                $user->password =  bcrypt(Input::get('password'));
            }
            else {
                flash('Passordene er ikke like!');
                return back();
            }
        }

        $user->save();

        Auth::setUser($user);

        flash('Brukeren ble oppdatert');
        return back();
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
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}

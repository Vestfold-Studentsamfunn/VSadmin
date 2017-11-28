<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use Kodeine\Acl\Models\Eloquent\Role;

use View;
//use Activity;

class UserController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the user.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::all();

        return View::make('settings.user_index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('settings.user_create');
    }

    /**
     * Show the form for creating a new user.
     *
     * @return Response
     */
    public function roles()
    {
        $roles = Role::all();

        return View::make('settings.user_roles', compact('roles'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return Response
     */
    public function postRoles()
    {
        $roles = Role::all();

        return View::make('settings.user_roles', compact('roles'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return View::make('settings.user_edit', [ 'user' => $user ]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $user = User::find($id);

        $user->first_name = Input::get('first_name');
        $user->last_name  = Input::get('last_name');
        $user->email      = Input::get('email');
        $user->password   = bcrypt(Input::get('password'));

        $user->save();

        //Activity::log(Auth::user()->getFullName(). ' oppdaterte brukeren '.$user);

        return \Redirect::to('/settings/users');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->getFullName();
        User::destroy($id);
        //Activity::log(Auth::user()->getFullName(). ' slettet brukeren '.$user);

        return \Redirect::to('/settings/users');
    }
}
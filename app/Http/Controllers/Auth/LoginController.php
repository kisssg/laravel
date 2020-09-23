<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }
    public function authenticated(Request $request){
        $user=$request->user();
        session(['valid_user'=>$user->username,
            'level'=>$user->level,
            'auth'=>["id"=>$user->id,
                "name"=>$user->username,
                "level"=>$user->level,
                "role"=>$user->role]]);
    }
    
    //for ldap login
    public function username() {
        return 'email';//was username
    }

}

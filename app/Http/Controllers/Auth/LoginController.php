<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Utils\BusinessUtil;

class LoginController extends Controller
{
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
     * All Utils instance.
     *
     */
    protected $businessUtil;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct( BusinessUtil $businessUtil )
    {
        $this->middleware('guest')->except('logout');
        $this->businessUtil = $businessUtil;
    }

    /**
     * Change authentication from email to username
     *
     * @return void
     */
    public function username()
    {
        return 'username';
    }

    public function logout(){
        request()->session()->flush();
        \Auth::logout();
        return redirect('/');
    }

    protected function redirectTo()
    {
        $user = \Auth::user();
        if ($user->hasRole('Cashier#' . $user->business_id )) {
            return '/pos/create';
        }

        return '/home';
    }
}

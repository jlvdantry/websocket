<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\AdipUtils\{SimpleCURL, LlaveCDMX};

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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(){
        $autenticator = new LlaveCDMX;
        $srvLlave=$autenticator->getAuthURI();
        $clientID=$autenticator->getClientId();
        $redirectTo_=$autenticator->getRedirectTo();
        $randomChars = Str::random(64);
        $uriGetCode=$srvLlave.'?client_id='.$clientID.'&redirect_url='.$redirectTo_.'&state='.$randomChars;
        //
        return Redirect::away($uriGetCode);
    }


}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App;

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
  //  protected $redirectTo = RouteServiceProvider::HOME;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
  
        $request->headers->get('accept-language');
      
        $this->middleware('guest')->except('logout');
       
    }

 public function showLoginForm(Request $request)
    {
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);  
        $language = $request->headers->get('accept-language');
        $language = explode(",", $language);
        $language = explode("-", $language[0]);
        return view('auth.login', [
            'language'=>$language[0],
        ]);
    }
  
      
}

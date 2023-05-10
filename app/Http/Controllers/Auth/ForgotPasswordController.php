<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    
    public function showLinkRequestForm(Request $request)
    {
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);  
        $language = $request->headers->get('accept-language');
        $language = explode(",", $language);
        $language = explode("-", $language[0]);
        return view('auth.passwords.email', [
            'language'=>$language[0],

            ]);
    }
}

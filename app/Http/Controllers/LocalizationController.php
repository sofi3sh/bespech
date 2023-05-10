<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class LocalizationController extends Controller
{
    
    
    
    public function index()
    {
        return view('login');
    }
    
    
    public function lang_change(Request $request)
    {
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);  
        return view('login');
    }
    
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\ApiHandBooks\Category\Category;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\CategoryDescription;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
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
    //  protected $redirectTo =  RouteServiceProvider::HOME;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {


       $this->middleware('guest');
    }

    public function showRegistrationForm(Request $request)
    {

        $languageId = 1;
//        $cats = Category::all();
        $users = User::all();
//        $locale = session()->get('locale');
        $cats = new Category();
        $categories = $cats->getCategoriesByLangId($languageId);
//        dd($categories);

        App::setLocale($request->lang);



//        $language = $request->headers->get('accept-language');
//        $language = explode(",", $language);
//        $language = explode("-", $language[0]);



        return view('auth.register', [
            'users'=>$users,
            'cats'=>$cats,
//            'language'=>$language[0],
            'categoriesDescriptionArr' => $categories,
            ]);
    }

    public function getCategory(){
        $languageId = $idCv = request('langId', null);;
        $cats = new Category();
        $categories = $cats->getCategoriesByLangId($languageId);
        $response['categoriesDescriptionArr'] = $categories;
        return $this->sendResponce($response, 200);
    }



    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function validator(Request $request)
    // {
    //     return Validator::make($request, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'category_id' => ['required', 'int', 'max:50'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //         'confirm_password' => 'required|same:password',
    //     ]);
    // }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(Request $request)
    {

        $this->Validator::make($request, [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'int', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'confirm_password' => 'required|same:password',
        ]);


        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['token'] = Str::random(70);
        $input['api_token'] = Str::random(60);
        $user = User::create($input);
        $success['token'] = $user->createToken('api-key')->plainTextToken;
        $success['name'] = $user->name;

        return redirect()->route('/access?token=', $success['token'] . '&newUser=false&role=' . $input['category_id'])->with('message', 'User created successfully');

        //   return  User::create([
        //         'name' => $data['name'],
        //         'category_id' => $data['category_id'],
        //         'email' => $data['email'],
        //         'password' => Hash::make($data['password']),
        //         'token' => Str::random(70),
        //         'api_token' => Str::random(60),
        //     ]);

    }


}

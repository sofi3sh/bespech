<?php
   
namespace App\Http\Controllers;
   
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\User;
use App\Models\Profile;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;



   
class AuthController extends BaseController
{
    use AuthenticatesUsers;
    
    public function signin(Request $request)
    {

        $this->middleware('guest')->except('logout');

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 

            $authUser = Auth::user(); 
            $success['token'] =  $authUser->createToken('api-key')->plainTextToken; 
            $success['name'] =  $authUser->name;
            $usering = DB::table('personal_access_tokens')->where('tokenable_id', Auth::user()->id)->value('token');

          
                $response = [
                    'response'=>[
                         'success' => true,
                         'user'=>[
                             'localizationId' => 1, 
                              'data'  => $authUser,
                             ]
                        ]
                ];
                
                return response()->json($response, 200); 
                
             
           
        } else { 
                   $response = [
                    'response'=>[
                         'success' => false,
                         'error' => 404
                        ]
                    ];
                    
                    return response()->json($response, 404);
         } 
         
         
    }
    
    
    
    
     public function signup(Request $request)
    {  
        $request->validate([
            'category_id' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => 'required|same:password',
           
        ]);
        
     
           
        $data = $request->all();
       
        $user = $this->create($data);

        $success['token'] =  $user->createToken('api-key')->plainTextToken;
        $success['name'] =  $user->name;
        
        $usering = DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->value('token');

       
        
        if($user){

        $response = [
            'response'=>[
                 'success' => true,
                 'user'=>[
                     'localizationId' => 1, 
                      'data'  => $user,
                     ]
                ]
        ];
        
        return response()->json($response, 200); 
        
        } else {
             $response = [
            'response'=>[
                 'success' => false,
                 'error' => 404
                ]
        ];
            
            return response()->json($response, 404);
        }
     
    }

    public function create(array $data)
    {
      return User::create([
        'category_id' => $data["category_id"],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        'token' => Str::random(70),
       
      ]);
      
    }    


   
}
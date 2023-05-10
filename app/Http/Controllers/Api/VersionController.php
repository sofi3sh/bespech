<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Version;
use App\Models\User;
use App\Models\Profile;


class VersionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $header = $request->header;
        
        $token = $request->header('token');
        $api_key = $request->header('api-key');
      //  dd($token,  $api_key);
       
        
        if($api_key == "d4d12fb2a814682bbdc0cba801cb5919edf1273a61007d82ca0bf331c59d7986"){
         
            $userId = DB::table('personal_access_tokens')->where('token', $token)->value('tokenable_id'); 
             $versions = Version::orderBy('id', 'desc')->first(); // last id
             
            if($userId){
                    $user = User::find($userId);
                    $isnweuser = Profile::where('user_id', $userId)->value('isnew_user');
                    
                    //new code
                    // не дуже хотііли лізти в БД (переробляти поле) тому конвертемо її тут
                    $isnweuser = filter_var($isnweuser, FILTER_VALIDATE_BOOLEAN);
                    //new code
                    
                    //dd($isnweuser, $user,$userId); 
                    $response = [
                        'response'=>[
                             'success' => true,
                             'versions'=>[
                                 'localizationId' => 1, // id мови укр
                                  'data'  => $versions,
                                 ],
                              "userInfo"=>[
                                        "isNewUser"=>$isnweuser,
                                        "role"=>$user->category_id,
                                    ]
                            ]
                    ];
                    
                    return response()->json($response, 200);
                    
            }else{
                    $response = [
                    'response'=>[
                         'success' => true,
                         'versions'=>[
                               'localizationId' => 1, // id мови укр
                                'data'  => $versions,
                                "userInfo"=> null,
                                // "error"=> 401,
                                // "message"=>"incorrect token"
                                ]   
                        ]
                    ];
                    // return response()->json($response, 401);
                    return response()->json($response, 200);
                                  
                            
            }      
      
        }  else {
                 $response = [
                'response'=>[
                     'success' => false,
                     'error' => 404,
                     'message' => 'not_found_api_key',
                    ]
                ];
                return response()->json($response, 404);
        }
        
    }

}

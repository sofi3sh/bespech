<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserFilter;
use lluminate\Support\Facades\URL;

class UserFilterConrtoller extends BaseController
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
        
           // to check token
        $userId = DB::table('personal_access_tokens')->where('token', $token)->value('tokenable_id');

        
        // api-key validation result
        $apiKeyValidationResult = $this->validateApikey($api_key);
        if($apiKeyValidationResult){
            return response()->json($apiKeyValidationResult['response'], $apiKeyValidationResult['code']);
        }
        
        // token validation result
        $tokenValidationResult = $this->validateUserToken($userId);
        if($tokenValidationResult){
            return response()->json($tokenValidationResult['response'], $tokenValidationResult['code']);
        }
        
        
        $user_filters =  UserFilter::all();
        
           $response = [
                'response'=>[
                     'success' => true,
                     'user_filters'=>[
                          'data'  => $user_filters,
                         ]
                    ]
            ];
            
            return response()->json($response, 200);
       
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     
    public function store(Request $request)
    {
        $header = $request->header;
        $token = $request->header('token');
        $api_key = $request->header('api-key');
        
           // to check token
        $userId = DB::table('personal_access_tokens')->where('token', $token)->value('tokenable_id');

        
        // api-key validation result
        $apiKeyValidationResult = $this->validateApikey($api_key);
        if($apiKeyValidationResult){
            return response()->json($apiKeyValidationResult['response'], $apiKeyValidationResult['code']);
        }
        
        // token validation result
        $tokenValidationResult = $this->validateUserToken($userId);
        if($tokenValidationResult){
            return response()->json($tokenValidationResult['response'], $tokenValidationResult['code']);
        }
        
        $input = $request->all();
        $user_filters =  UserFilter::where('user_id', $userId)->get();
        

        if($user_filters){
            // $user_filters->id_region = $input['id_region'];
            // $user_filters->id_city = $input['id_city'];
            // $user_filters->selected_condition = $input['selected_condition'];
            // $user_filters->salary_min = $input['salary_min'];
            // $user_filters->salary_max = $input['salary_max'];
            
            dd($user_filters->salary_max);  
           // $user_filters->save();
        
        }else{
            // $user_filters = UserFilter::create([
            //     "user_id"=> $userId,
            //     "id_region"=> $input['id_region'],
            //     "id_city"=> $input['id_city'],
            //     "selected_condition"=> $input['selected_condition'],
            //     "salary_min"=> $input['salary_min'],
            //     "salary_max"=> $input['salary_max']
            // ]);

        }
        
           $response = [
                'response'=>[
                     'success' => true,
                     'user_filters'=>[
                          'data'  => $user_filters,
                         ]
                    ]
            ];
            
            return response()->json($response, 200);
    }

   
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\User;
use App\Models\Profile;
use Validator;

class CompanyController extends BaseController
{
    public function index(Request $request){
        $header = $request->header;
        $token = $request->header('token');
        $api_key = $request->header('api-key');
        
        // to check token
        $userId = DB::table('personal_access_tokens')->where('token', $token)->value('tokenable_id');
        $category = User::where('id', $userId)->first();
        $correctCategoryId = 2;
        
        // api-key validation result
        $apiKeyValidationResult = $this->validateApikey($api_key);
        if($apiKeyValidationResult){
            return response()->json($apiKeyValidationResult['response'], $apiKeyValidationResult['code']);
        }
        
        // token validation result
        $tokenValidationResult = $this->validateUserToken($userId, $category, $correctCategoryId);
        if($tokenValidationResult){
            return response()->json($tokenValidationResult['response'], $tokenValidationResult['code']);
        }
        
        $companies = Company::where('user_id', $userId)->first();
        $response = [
            'response'=>[
                 'success' => true,
                 'companies'=>[
                     'localizationId' => 1, 
                      'data'  => $companies,
                     ]
                ]
        ];
        return response()->json($response, 200);
    }
    
    public function store(Request $request){
        $header = $request->header;
        $token = $request->header('token');
        $api_key = $request->header('api-key');
        
        // to check token
        $userId = DB::table('personal_access_tokens')->where('token', $token)->value('tokenable_id');
        $category = User::where('id', $userId)->first();
        $correctCategoryId = 2;
        
        // api-key validation result
        $apiKeyValidationResult = $this->validateApikey($api_key);
        if($apiKeyValidationResult){
            return response()->json($apiKeyValidationResult['response'], $apiKeyValidationResult['code']);
        }
        
        // token validation result
        $tokenValidationResult = $this->validateUserToken($userId, $category, $correctCategoryId);
        if($tokenValidationResult){
            return response()->json($tokenValidationResult['response'], $tokenValidationResult['code']);
        }
            
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'phone' => 'required|numeric|digits_between:10,12',
        ];
        
        $this->bindMesages();
        $validator = Validator::make($request->all(), $rules, $this->bindMesages());
        
        if($validator->fails()){
            return $this->sendValidationError('validation_error', $validator->errors(), 422);       
        }
        
        $input = $request->all();
        $company = Company::where('user_id', $userId)->first();
        $profile = Profile::where('user_id', $userId)->first();
        
        if($company){
            $company->name = $input['name'];
            $company->address = $input['address'];
            $company->phone = $input['phone'];
            $company->email = $input['email'];
            $company->save();
            $profile->isnew_user = false;
            $profile->save();
        }else{
            $company = Company::create([
                "user_id"=> $userId,
                "lang_id"=> 1,
                "name"=> $input['name'],
                "address"=> $input['address'],
                "phone"=> $input['phone'],
                "email"=> $input['email']
            ]);
            $profile->isnew_user = false;
            $profile->save();
        }
        $response = [
            'response'=>[
                    'success' => true,
                    'company'=>[
                        'localizationId' => 1,
                        'data'  => $company,
                    ]
            ]
        ];
        return response()->json($response, 201);
    } 
}
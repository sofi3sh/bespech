<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Education;
use App\Models\User;
use App\Models\Profile;

use Validator;

class EducationController extends BaseController
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
        
        // for tocken check
        $userId = DB::table('personal_access_tokens')->where('token', $token)->value('tokenable_id');
        $category = User::where('id', $userId)->first();
        $correctCategoryId = 3;
        
        // validation result
        $apiKeyValidationResult = $this->validateApikey($api_key);
        if($apiKeyValidationResult){
            return response()->json($apiKeyValidationResult['response'], $apiKeyValidationResult['code']);
        }
        
        // validation result
        $tokenValidationResult = $this->validateUserToken($userId, $category, $correctCategoryId);
        if($tokenValidationResult){
            return response()->json($tokenValidationResult['response'], $tokenValidationResult['code']);
        }
                
        $educationies = Education::where('user_id', $userId)->first();
        $response = [
            'response'=>[
                 'success' => true,
                 'educationies'=>[
                     'localizationId' => 1, // id мови укр
                      'data'  => $educationies,
                     ]
              ]
        ];
        return response()->json($response, 200); // return response()->json($posts);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $header = $request->header;
        $token = $request->header('token');
        $api_key = $request->header('api-key');
        
        // to check token
        $userId = DB::table('personal_access_tokens')->where('token', $token)->value('tokenable_id');
        $category = User::where('id', $userId)->first();
        $correctCategoryId = 3;

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
            return $this->sendValidationErrorDelete('validation_error', $validator->errors(), 422);       
        }
        
        $input = $request->all();
        $education = Education::where('user_id', $userId)->first();
        $profile = Profile::where('user_id', $userId)->first();
        if($education){
           
            $education->name = $input['name'];
            $education->address = $input['address'];
            $education->phone = $input['phone'];
            $education->email = $input['email'];
            $education->save();
            
            $profile->isnew_user = false;
            $profile->save();
            
        }else{

            $education = Education::create([
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
                     'educationies'=>[
                         'localizationId' => 1, // id мови укр
                          'data'  => $education,
                         ]
                  ]
        ];
        return response()->json($response, 201);
    } 
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Education  $educations
     * @return \Illuminate\Http\Response
     */
    public function show(Education $educations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Education  $educations
     * @return \Illuminate\Http\Response
     */
    public function edit(Education $educations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Education  $educations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $educations->update($request->all());
        
        return  response()->json($educations, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Education  $educations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Education $educations)
    {
        $educations->delete();

        return  response()->json( 200);
    }
}


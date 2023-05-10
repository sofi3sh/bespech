<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\VacanciesConditionDoc;
use lluminate\Support\Facades\URL;

class ConditionController extends BaseController
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

        $vacanciesConditionDocs =  VacanciesConditionDoc::all();
        


         foreach($vacanciesConditionDocs as $vacanciesConditionDoc){
                $сonditionDoc [] = [
                          "id" => $vacanciesConditionDoc->id,
                          "name" =>  $vacanciesConditionDoc->name,
                        ];
          } 

         $response["response"] = [  
             'success' => true,
              "conditions"=> $сonditionDoc,
            ];

        return response()->json($response, 200); 

    
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

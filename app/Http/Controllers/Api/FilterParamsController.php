<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\CityZone;
use App\Models\Region;
use App\Models\VacanciesConditionDoc;
use lluminate\Support\Facades\URL;

class FilterParamsController extends BaseController
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


        $all_citys =  CityZone::all();
        $regions =  Region::all();
        $vacanciesConditionDocs =  VacanciesConditionDoc::all();


        foreach($regions as $region){
                $data [] = [
                          "id"     => $region->id,
                          "reg_id" => 0,
                          "name"   =>  $region->name,
                        ];
          }
         foreach($all_citys as $all_city){
                $data [] = [
                          "id"     => $all_city->id,
                          "reg_id" => $all_city->region_id,
                          "name"   =>  $all_city->name,
                        ];
          }
         foreach($vacanciesConditionDocs as $vacanciesConditionDoc){
                $сonditionDoc [] = [
                          "id" => $vacanciesConditionDoc->id,
                          "name" =>  $vacanciesConditionDoc->name,
                        ];
          }

         $response["response"] = [
             'success' => true,
              "locations"=> $data,
              "conditions"=> $сonditionDoc,
            ];

        return response()->json($response, 200);

    }


}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Issaved;
use App\Models\Vacancy;
use App\Models\Vacancy_dcz;
use App\Models\CityZone;
use lluminate\Support\Facades\URL;


class IssavedController extends BaseController
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
        $limit = 10;
        
        if ($request->has('limit')) {
          $limit = $request->input('limit');
        }
        
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
        

       
          
            $issaveds = Issaved::select('id_vac')
                ->where('user_id', $userId)
                ->get();

        $vacany_dcz = Vacancy::select('id', 'company_name', 'city_id')->whereIn('id', $issaveds)->paginate($limit);



        $response = [
            'response' => [
                'success' => true,
                'vacancies' => [
                    'localizationId' => 1, // id мови укр
                    'data' => $vacany_dcz->map(function ($vacancy) {
                        $сity_zone = new CityZone();
                        $city_region_id = $сity_zone->getCityNameById($vacancy->city_id);

                        return [
                            'id' => $vacancy->id,
                            'is_saved' => true,
                            'info' => [
                                'cityName' => $city_region_id['city_name'],
                                'vacName' => $vacancy->getVacancyDescription->first()->vac_name,
                                'salary' => $vacancy->getVacancySalary->first()->salary_txt,
                                'companyName' => $vacancy->company_name,
                            ],
                        ];
                    })
                ]
            ]
        ];
        //   $vacany_dcz = Vacancy::select('id', 'cityName', 'vacName', 'salary','categoryName')->whereIn('id', $issaveds)->paginate($limit);

                
            
        // $response = [
        //     'response'=>[
        //         'success' => true,
        //         'vacancies'=>[
        //             'localizationId' => 1, // id мови укр
        //               'data' => $vacany_dcz->map(function ($vacancy) {       
        //                 return [
        //                     'id' => $vacancy->id,
        //                     'is_saved' => true,
        //                     'info' => [
        //                         'cityName' => $vacancy->cityName,
        //                         'vacName' => $vacancy->vacName,
        //                         'salary' => $vacancy->salary,
        //                         'categoryName' => $vacancy->categoryName,
        //                     ],
        //                 ];
        //             })
        //         ]
        //     ]
        // ];

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
          
            if ($request->has('id')) {
               $id_vac = $request->input('id');
        } 
       
        
          $userId = DB::table('personal_access_tokens')->where('token', $token)->value('tokenable_id');

            $tokenValidationResult = $this->validateUserToken($userId);
            if($tokenValidationResult){
                return response()->json($tokenValidationResult['response'], $tokenValidationResult['code']);
            }
        
        

        
        $issaved_id = Issaved::where('user_id', $userId)->where('id_vac',$id_vac)->get();
 

            
         if($wordCount = count($issaved_id) > 0){
             foreach ($issaved_id as $issaved){
              Issaved::where('id', $issaved->id)->delete();

            $issaved = false;
         }
        } else {

                  $issaved = [
                                'user_id' => $userId,
                                'id_vac' => $request->id,
                                'is_saved' => true,
                               ];             
         
                $issaved = Issaved::insert($issaved);
        }
            
         $response = [
            'response'=>[
                        'success' => true,
                        'vacancy_id' => (int)$request->id,
                        'is_saved'  => $issaved,
            ]
        ];
        return response()->json($response, 201);
    }
    

}

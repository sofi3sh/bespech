<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\FiltersController;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Vacancy;
use App\Models\CityZone;
use App\Models\VacanciesContact;
use App\Models\Issaved;
use lluminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;
use function PHPUnit\Framework\isEmpty;

class VacancyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $сity_zone = new CityZone();
        $header = $request->header;
        $token = $request->header('token');
        $api_key = $request->header('api-key');
        $limit = 10;
        $id = '';
        $lang_id = 1;


        if ($request->has('limit')) {
            $limit = $request->input('limit');
        }
        if ($request->has('id')) {
            $id = $request->input('id');
        }
        if($request->headers->get('token') === null){
            $response = App::call('\App\Http\Controllers\Api\Quest\QuestVacancyController@index', [$request->all()]);
            return response()->json($response, 200);
        }
        $userId = DB::table('personal_access_tokens')->where('token', $token)->value('tokenable_id');
        // api-key validation result
        $apiKeyValidationResult = $this->validateApikey($api_key);
        if ($apiKeyValidationResult) {
            return response()->json($apiKeyValidationResult['response'], $apiKeyValidationResult['code']);
        }

        // token validation result
        $tokenValidationResult = $this->validateUserToken($userId);
        if ($tokenValidationResult) {
            return response()->json($tokenValidationResult['response'], $tokenValidationResult['code']);
        }

        if($id){
            $vacancy = Vacancy::find($id);
            $descriptionResult = $vacancy->getVacancyDescription->where('language_id', $lang_id)->first();
            $city_region_id = $сity_zone->getCityNameById($vacancy->city_id);
            $salaryResult = $vacancy->getVacancySalary->first();
            $conditionResult = $vacancy->getVacancyCondition->pluck('name')->toArray();
            $currencyResult = $vacancy->getVacancyCurrency->first();
            $contactsResult = $vacancy->getVacancyContacts;

            $contacts = [
                'emails' => null,
                'phones' => null,
            ];
            foreach ($contactsResult as $item) {
                if (!empty($item->email)) {
                    $contacts['emails'][] = $item->email;
                }
                if (!empty($item->phone)) {
                    $contacts['phones'][] = $item->phone;
                }
            }
            $contacts['emails'] = $contacts['emails'] ? array_unique($contacts['emails']) : null;
            $contacts['phones'] = $contacts['phones'] ? array_unique($contacts['phones']) : null;


            $issaved = Issaved::select('is_saved')
                ->where('id_vac', $id)
                ->where('user_id', $userId)
                ->first();

            $issaved = $issaved ? filter_var($issaved->is_saved, FILTER_VALIDATE_BOOLEAN) : false;



            $response = [
                'response' => [
                    'success' => true,
                    'vacancies' => [
                        'localizationId' => 1, // id мови укр
                        'data' => [
                            'id' => $vacancy->id,
                            'is_saved' => $issaved,
                            'info' => [
                                "regionName" => $city_region_id['region_name'],
                                "cityName" => $city_region_id['city_name'],
                                "companyName" => $vacancy->company_name,
                                "vacName" => $descriptionResult->vac_name,
                                "description" => $descriptionResult->description,
                                "workcond" => $conditionResult,
                                "contacts" => $contacts,
                                "salary" => [
                                    'salaryValue' => $salaryResult->salary,
                                    'salaryTxt' => $salaryResult->salary_txt,
                                    'currency' => [
                                        'currencyId' => $currencyResult->id,
                                        'currencyCode' => $currencyResult->code,
                                    ],
                                ],
                                "education" => $vacancy->education,
                                "source" => $vacancy->source,
                                "language_id" => $descriptionResult->language_id,
                                "created_at" => $vacancy->created_at,
                                "updated_at" => $vacancy->updated_at
                            ],
                        ],
                    ]
                ]
            ];

            return response()->json($response, 200);
        } else {
            $сity_zone = new CityZone();

            $search = request('search', '');
            $minsalary = request('minsalary', '');
            $maxsalary = request('maxsalary', '');
            $condition = request('condition', []);
            $cityid = request('cityid', '');
            $regionid = request('regionid', '');

            $filtersController = new FiltersController();
            $query = $filtersController->filterVacantions($search, $minsalary, $maxsalary, $condition, $cityid, $regionid);

            $vacancies = $query->select('id', 'company_name', 'city_id')->paginate($limit);

            $issaveds = Issaved::select('id_vac', 'is_saved')
                ->where('user_id', $userId)
                ->whereIn('id_vac', $query->pluck('id'))
                ->get()
                ->keyBy('id_vac');

            $response = [
                'response' => [
                    'success' => true,
                    'vacancies' => [
                        'localizationId' => 1, // id мови укр
                        'data' => $vacancies->map(function ($vacancy) use ($issaveds, $сity_zone) {
                            $isSaved = $issaveds->get($vacancy->id);
                            $is_saved = $isSaved ? $isSaved->is_saved : false;
                            $city_region_names = $сity_zone->getCityNameById($vacancy->city_id);
                            return [
                                'id' => $vacancy->id,
                                'is_saved' => filter_var($is_saved, FILTER_VALIDATE_BOOLEAN),
                                'info' => [
                                    'cityName' => $city_region_names['city_name'],
                                    'vacName' => $vacancy->getVacancyDescription->first()->vac_name,
                                    'salary' => $vacancy->getVacancySalary->first()->salary,
//                                    'categoryName' => $vacancy->categoryName,
                                ],
                            ];
                        })
                    ]
                ]
            ];
//            $issaveds = Issaved::select('id_vac', 'is_saved')
//                ->where('user_id', $userId)
//                ->whereIn('id_vac', $vacany_dcz->pluck('id'))
//                ->get()
//                ->keyBy('id_vac');
//
//            $response = [
//                'response' => [
//                    'success' => true,
//                    'vacancies' => [
//                        'localizationId' => 1, // id мови укр
//                        'data' => $vacany_dcz->map(function ($vacancy) use ($issaveds) {
//                            $isSaved = $issaveds->get($vacancy->id);
//                            $is_saved = $isSaved ? $isSaved->is_saved : false;
//                            return [
//                                'id' => $vacancy->id,
//                                'is_saved' => filter_var($is_saved, FILTER_VALIDATE_BOOLEAN),
//                                'info' => [
//                                    'cityName' => $vacancy->cityName,
//                                    'vacName' => $vacancy->vacName,
//                                    'salary' => $vacancy->salary,
//                                    'categoryName' => $vacancy->categoryName,
//                                ],
//                            ];
//                        })
//                    ]
//                ]
//            ];

            return response()->json($response, 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $сity_zone = new CityZone();
        $vacancy = new Vacancy();

        $vacanties = file_get_contents("https://dczworknowbot.dcz.gov.ua:334/api/vac/getenergo");
        $data = json_decode($vacanties,true);
        $vacancy->getOnlyDczVac();

        $putedVacs = 0;
        $updatedVacs = 0;

        foreach ($data['data'] as $key=>$value){
            if($key < 200){
                try{
                    //check phone number
                    $patternPhone = '/\+?\d{0,3}\s*\(?(\d{3})\)?[-.\s]*\d{3}[-.\s]*\d{2}[-.\s]*\d{2}/';
                    $description = $data['data'][$key]["description"];
                    preg_match_all($patternPhone, $description, $matches);
                    if($matches[0]){
                        $str = $matches[0][0];
                        $str = preg_replace('/\D/', '', $str);
                        $str = preg_replace('/^\+?3?8?\(?0*([1-9]\d{1,2})[\)\-\s]*([\d\-]{5,10})$/', '0$1$2', $str);
                    }else{
                        continue;
                    }

                    //check data of registration
                    if(is_null($data['data'][$key]["reg_date"])){
                        $date = date('Y-m-d H:i:s', time());
                    }else{
                        $date_str = $data['data'][$key]["reg_date"];
                        $timestamp = strtotime($date_str);
                        $date = date('Y-m-d H:i:s', $timestamp);
                    }

                    //check dzc vac description
                    if(is_null($data['data'][$key]["salarytxt"])){
                        $data['data'][$key]["salarytxt"] = 'договірна';
                    }
                    $localisationId = $сity_zone->getCityIdAndRegionIDByCityName($data['data'][$key]["cityname"]);

                    $dataValues = [
                        'id_dcz_vac' => $data['data'][$key]["id0"],
                        'status' => 1,
                        'region_id' => $localisationId['region_id'],
                        'city_id' => $localisationId['city_id'],
                        'company_name' => $data['data'][$key]["companyname"],
                        'education' => 'освіта',
                        'source' => 'dcz',
                        'register_date' => $date,
                    ];

                    $vacancyOld = Vacancy::where('id_dcz_vac', $data['data'][$key]["id0"])->first();

                    if($vacancyOld){
                        $vacancyOld->fill($dataValues);
                        $vacancyOld->save();
                        $updatedVacs++;
                    }else{
                        $vacancy = new Vacancy();
                        $vacancy->fill($dataValues);
                        $vacancy->save();

                        $vacancyDescriptions = [
                            'description' => $data['data'][$key]["description"],
                            'vac_name'=> $data['data'][$key]["vacname"],
                            'language_id' => 1,
                            'vac_id' => $vacancy->id,
                        ];
                        $vacancyContact = [
                            'vac_id' => $vacancy->id,
                            'email' => null,
                            'phone' => $str,
                        ];
                        $vacancyCondition = [
                            'vac_id' => $vacancy->id,
                            'condition_id' => 1,
                            'language_id' => 1,
                        ];
                        $vacancySalary = [
                            'vac_id' => $vacancy->id,
                            'salary' => $data['data'][$key]["salary"],
                            'salary_txt' => $data['data'][$key]["salarytxt"],
                            'currency_id' => 1,
                        ];
                        // all related tables
                        $vacancy->addVacanciesSalary($vacancySalary);
                        $vacancy->addVacanciesContact($vacancyContact);
                        $vacancy->addVacancyDescription($vacancyDescriptions);
                        $vacancy->addVacanciesCondition($vacancyCondition);
                        $putedVacs++;
                    }
                }catch(Exception $e){

                }
            }
        }
        $response = [
            'response'=>[
                'success' => true,
                'vacanties'=>[
                    'localizationId' => 1,
                    'the number of vacancies added to database'  => $putedVacs,
                    'the number of vacancies updated in database'  => $updatedVacs,
                ]
            ]
        ];
        return response()->json($response, 201);
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

// $dataValues = [
//     'id_dcz_vac' => $data['data'][$key]["id0"],
//     'region_id' => $data['data'][$key]["regionname"],
//     'cityName' => $data['data'][$key]["cityname"],
//     'cityid' => $data['data'][$key]["cityid"],
//     'companyName' => $data['data'][$key]["companyname"],
//     'vacName' => $data['data'][$key]["vacname"],
//     'description' => $data['data'][$key]["description"],
//     'workcond' => $data['data'][$key]["workcond"],
//     'workcondsm' => $data['data'][$key]["workcondsm"],
//     'contact' => $data['data'][$key]["contact"],
//     'salary' => $data['data'][$key]["salary"],
//     'salarytxt' => $data['data'][$key]["salarytxt"],
//     'currency' => $data['data'][$key]["currency"],
//     'categoryNameId' => $data['data'][$key]["branchnnameid"],
//     'categoryName' => $data['data'][$key]["branchnname"],
//     'workExperience' => $data['data'][$key]["cityid"],
//     'education' => $data['data'][$key]["cityid"],
//     'vac_id' => $data['data'][$key]["vacid"],
//     'vac_url' => $data['data'][$key]["vac_url"],
//     'source' => $data['data'][$key]["source"],
//     // 'language_id' => 1,
// ];

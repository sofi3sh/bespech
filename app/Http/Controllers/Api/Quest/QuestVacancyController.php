<?php

namespace App\Http\Controllers\Api\Quest;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\FiltersController;
use Illuminate\Http\Request;
use App\Models\CityZone;
use App\Models\Vacancy;



class QuestVacancyController extends BaseController
{
    public function index(Request $request)
    {
        $сity_zone = new CityZone();
        $header = $request->header;
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
        // api-key validation result
        $apiKeyValidationResult = $this->validateApikey($api_key);
        if ($apiKeyValidationResult) {
            return response()->json($apiKeyValidationResult['response'], $apiKeyValidationResult['code']);
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
            $response = [
                'response' => [
                    'success' => true,
                    'vacancies' => [
                        'localizationId' => 1, // id мови укр
                        'data' => [
                            'id' => $vacancy->id,
                            'is_saved' => false,
                            'info' => [
                                "regionName" => $city_region_id['region_name'],
                                "cityName" => $city_region_id['city_name'],
                                "companyName" => $vacancy->company_name,
                                "vacName" => $descriptionResult->vac_name,
                                "description" => $descriptionResult->description,
                                "workcond" => $conditionResult,
                                "contact" => $contacts,
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
            return $response;
        }else{
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

            $response = [
                'response' => [
                    'success' => true,
                    'vacancies' => [
                        'localizationId' => 1, // id мови укр
                        'data' => $vacancies->map(function ($vacancy) use ($сity_zone){
                            $city_region_names = $сity_zone->getCityNameById($vacancy->city_id);
                            return [
                                'id' => $vacancy->id,
                                'is_saved' => false,
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
            return $response;
        }
    }
}
// test

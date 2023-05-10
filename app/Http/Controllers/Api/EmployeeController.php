<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Models\CityZone;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Profile;
use App\Models\User;
use Validator;

class EmployeeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $header = $request->header;
        $token = $request->header('token');
        $api_key = $request->header('api-key');


        // to check token
        $userId = DB::table('personal_access_tokens')->where('token', $token)->value('tokenable_id');
        $category = User::where('id', $userId)->first();
        $correctCategoryId = 1;
//        dd($userId);

//        dd($token);

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

        $employees = Employee::where('user_id', $userId)->first();

        if($employees == null){
            $response = [
                'response'=>[
                    'success' => true,
                    'employees'=>[
                        'localizationId' => 1, // id мови укр
                        'data'  => null
                    ]
                ]
            ];
            return response()->json($response, 200);
        }

        $cityZone = new CityZone();

        $userCity = $cityZone->getCityNameById($employees['city']);


        if($employees){
            $email = '';


            foreach ($employees->getEmailEmployee as $email) {
                $email = $email->email;
            }
            $response = [
                'response'=>[
                    'success' => true,
                    'employees'=>[
                        'localizationId' => 1, // id мови укр
                        'data'  => [
//                            'photo' => 1,
                            'photo' => $employees['photo'],
                            'name' => $employees['name'],
                            'lastName' => $employees['lastName'],
                            'phone' => $employees['phone'],
                            'email' => $email,
                            'dateOfBirth' => $employees['dateOfBirth'],
                            'city' => $userCity,
                            'social' => $employees['social'],
                            'gender' => $employees['gender'],
                        ],
                    ]
                ]
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'response'=>[
                    'success' => true,
                    'employees'=> null,
                ]
            ];
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

        $userId = DB::table('personal_access_tokens')->where('token', $token)->value('tokenable_id');

        $category = User::where('id', $userId)->first();

        $correctCategoryId = 1;

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

        // приклад як в поле вставляти регулярку
        // 'name' => ['required', 'regex:/(\b\w{2})(\w)/'],
        $rules = [
            'gender' => ["integer","min:0","max:2"],
        ];

        $this->bindMesages();
        $validator = Validator::make($request->all(), $rules, $this->bindMesages());

        if($validator->fails()){
            return $this->sendValidationError('validation_error', $validator->errors(), 422);
        }

        $input = $request->all();
        $employee = Employee::where('user_id', $userId)->first();
        $profile = Profile::where('user_id', $userId)->first();



        if($employee){
            $employee->photo = $input['photo'];
            $employee->name = $input['name'];
            $employee->lastName = $input['lastName'];
            $employee->phone = $input['phone'];
            $employee->email = $input['email'];
            $employee->dateOfBirth = $input['dateOfBirth'];
            $employee->city = (int)$input['city'];
            $employee->social = $input['social'];
            $employee->gender = (int)$input['gender'];
            $employee->save();
            $profile->isnew_user = false;
            $profile->save();

            //   $input['photo'] ?  $employee->photo =$input['photo'] : '';
            //   $input['name'] ?  $employee->name = $input['name']  : '';
            //   $input['lastName'] ?  $employee->lastName = $input['lastName']  : '';
            //   $input['phone'] ?  $employee->phone = $input['phone'] : '';
            //   $input['email'] ?   $employee->email = $input['email'] : '';
            //   $input['dateOfBirth'] ?  $employee->dateOfBirth = $input['dateOfBirth'] : '';
            //   $input['city'] ?  $employee->city = $input['city'] : '';
            //   $input['social'] ?   $employee->social = $input['social'] : '';
            //   $input['gender'] ?  $employee->gender = $input['gender'] : '';
        }
        else{
            $employee = Employee::create([
                "user_id"=> $userId,
                "lang_id"=> 1,
                'photo' => $input['photo'],
                "name"=> $input['name'],
                "lastName"=> $input['lastName'],
                "phone"=> $input['phone'],
                "email"=> $input['email'],
                "dateOfBirth"=> $input['dateOfBirth'],
                "city"=> (int)$input['city'],
                "social"=> $input['social'],
                "gender"=> (int)$input['gender']
                // поставити на тернарний оператор щоб при  удате не оновлювало якщо немає ключа
            ]);
            $profile->isnew_user = false;
            $profile->save();
        }
        $response = [
            'response'=>[
                'success' => true,
                'employee'=>[
                    'localizationId' => 1, // id мови укр
                    'data'  => $employee,
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
    public function update(Request $request)
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

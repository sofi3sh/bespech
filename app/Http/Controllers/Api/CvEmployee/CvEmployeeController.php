<?php

namespace App\Http\Controllers\Api\CvEmployee;

use App\Http\Controllers\BaseController;
use App\Models\CvEmployee\EmployeesCv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CvEmployeeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $token = $request->header('token');
        $api_key = $request->header('api-key');
        $userId = DB::table('personal_access_tokens')->where('token', $token)->value('tokenable_id');
        $cvId = null;
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
        if ($request->has('cvId')) {
            $cvId = $request->input('cvId');
        }
        if($cvId){
            $employeesCv = EmployeesCv::findOrFail($cvId);

            $employeesCvEmails = $employeesCv->getCvEmails();
            $employeesCvPhones = $employeesCv->getCvPhones();
            $employeesCvConditions = $employeesCv->getCvConditions();

            $response = [
                'response' => [
                    'success' => true,
                    'employeeCv' => [
                        'id' => $employeesCv->id,
                        'userId' => $employeesCv->user_id,
                        'langId' => $employeesCv->lang_id,
                        'photo' => $employeesCv->photo,
                        'userName' => $employeesCv->user_name,
                        'education' => $employeesCv->education,
                        'course' => $employeesCv->course,
                        'workExperience' => $employeesCv->work_experience,
                        'job' => $employeesCv->job,
                        'convenientTime' => $employeesCv->convenient_time,
                        'description' => $employeesCv->description,
                        'badHabits' => $employeesCv->bad_habits,
                        'beneficiaries' => $employeesCv->beneficiaries,
                        'yourExpectation' => $employeesCv->your_expectation,
                        'salary' => $employeesCv->salary,
                        'moving' => $employeesCv->moving,
                        'cvConditionsIds' => $employeesCvConditions,
                        'emails' => $employeesCvEmails,
                        'phones' => $employeesCvPhones,
                    ]
                ]
            ];

            return response()->json($response, 200);
        }else{

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $token = $request->header('token');
        $api_key = $request->header('api-key');
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

        $idCv = $request->input('idCv');

        if(!$idCv){
            //create
            $message = "Data saved successfully.";

            $data = [
                'user_id' => $request->input('userId'),
                'lang_id' => $request->input('langId'),
                'photo' => $request->input('photo'),
                'user_name' => $request->input('userName'),
                'education' => $request->input('education'),
                'course' => $request->input('course'),
                'work_experience' => $request->input('workExperience'),
                'job' => $request->input('job'),
                'convenient_time' => $request->input('convenientTime'),
                'description' => $request->input('description'),
                'bad_habits' => $request->input('badHabits'),
                'beneficiaries' => $request->input('beneficiaries'),
                'your_expectation' => $request->input('yourExpectation'),
                'salary' => $request->input('salary'),
                'moving' => $request->input('moving')
            ];
            //validation
            //обов'язково вернутись до цього
            //тут можливість кинути стрічку
            if(gettype($request->input('cvConditionsIds')) != 'array'){
                $cvConditionsIds = json_decode($request->input('cvConditionsIds'), TRUE);
            }else{
                $cvConditionsIds = $request->input('cvConditionsIds');
            }
            if(gettype($request->input('phones')) != 'array'){
                $cvPhones = json_decode($request->input('phones'), TRUE);
            }else{
                $cvPhones = $request->input('phones');
            }
            if(gettype($request->input('emails')) != 'array'){
                $cvEmails = json_decode($request->input('emails'), TRUE);
            }else{
                $cvEmails = $request->input('emails');
            }
            //обов'язково вернутись до цього
            //тут можливість кинути стрічку
            //validation

            $employeesCv = EmployeesCv::create($data);
            $employeesCv->addOrUpdateCvConditions($cvConditionsIds, $employeesCv->id);
            $employeesCv->addOrUpdateCvPhones($cvPhones, $employeesCv->id);
            $employeesCv->addOrUpdateCvEmails($cvEmails, $employeesCv->id);


            if ($request->hasFile('sertificateFiles')) {
                $files = $request->file('sertificateFiles');
                $cvId = $employeesCv->id;
                $employeeId = $data['user_id'];

                // перевірка максимальне допустиме значення файлів в директорії
                $maxFiles = 5;
                $dir = public_path("uploads/Employees/$employeeId/userCvs/$cvId");
                $dirFiles = glob("$dir/*");
                $numFiles = count($dirFiles);
                $numNewFiles = count($files);
                if ($numFiles + $numNewFiles > $maxFiles) {
                    return response()->json([
                        'success' => true,
                        'code' => 200,
                        'message' => "Data saved successfully. You can't add more than $maxFiles files.",
                    ], 400);
                    // $message = $message . " You can't add more than $maxFiles files.";
                }

                foreach ($files as $file) {
                    // перевірка на формати файлів
                    $allowedFormats = ['pdf', 'png', 'jpg', 'jpeg', 'docx'];
                    $fileExtension = $file->getClientOriginalExtension();
                    if (!in_array($fileExtension, $allowedFormats)) {
                        return response()->json([
                            'success' => true,
                            'code' => 200,
                            'message' => "Data saved successfully. Incorrect file format.",
                        ], 400);
                        // $message = $message . " Incorrect file format.";
                    }
                }

                foreach ($files as $file) {
                    $filename = $file->getClientOriginalName();
                    $filesize = $file->getSize();
                    $file->move(public_path("uploads/Employees/$employeeId/userCvs/$cvId"), $filename);
                    $employeesCv->addCvFiles($filename, $filesize, $cvId);
                }
            }


            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => $message,
            ], 200);

        }else{
            $message = 'Data updated successfully.';
            $employeesCv = EmployeesCv::findOrFail($idCv);

            $data = [
                'user_id' => $request->input('userId') ?? $employeesCv->user_id,
                'lang_id' => $request->input('langId') ?? $employeesCv->lang_id,
                'photo' => $request->input('photo') ?? $employeesCv->photo,
                'user_name' => $request->input('userName') ?? $employeesCv->user_name,
                'education' => $request->input('education') ?? $employeesCv->education,
                'course' => $request->input('course') ?? $employeesCv->course,
                'work_experience' => $request->input('workExperience') ?? $employeesCv->work_experience,
                'job' => $request->input('job') ?? $employeesCv->job,
                'convenient_time' => $request->input('convenientTime') ?? $employeesCv->convenient_time,
                'description' => $request->input('description') ?? $employeesCv->description,
                'bad_habits' => $request->input('badHabits') ?? $employeesCv->bad_habits,
                'beneficiaries' => $request->input('beneficiaries') ?? $employeesCv->beneficiaries,
                'your_expectation' => $request->input('yourExpectation') ?? $employeesCv->your_expectation,
                'salary' => $request->input('salary') ?? $employeesCv->salary,
                'moving' => $request->input('moving') ?? $employeesCv->moving,
            ];


            if(gettype($request->input('cvConditionsIds')) != 'array'){
                $cvConditionsIds = json_decode($request->input('cvConditionsIds'), TRUE);
            }else{
                $cvConditionsIds = $request->input('cvConditionsIds');
            }
            if(gettype($request->input('phones')) != 'array'){
                $cvPhones = json_decode($request->input('phones'), TRUE);
            }else{
                $cvPhones = $request->input('phones');
            }
            if(gettype($request->input('emails')) != 'array'){
                $cvEmails = json_decode($request->input('emails'), TRUE);
            }else{
                $cvEmails = $request->input('emails');
            }


            $employeesCv->update($data);
            $employeesCv->addOrUpdateCvConditions($cvConditionsIds, $employeesCv->id);
            $employeesCv->addOrUpdateCvPhones($cvPhones, $employeesCv->id);
            $employeesCv->addOrUpdateCvEmails($cvEmails, $employeesCv->id);

            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => $message,
            ], 200);

        }
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

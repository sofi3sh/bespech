<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Vacancy;
use App\Models\VacancyDescription;
use App\Models\VacanciesContact;
use App\Models\VacanciesWork;
use App\Models\Issaved;
use lluminate\Support\Facades\URL;

class VacancydczControlle extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vacanties = file_get_contents("https://dczworknowbot.dcz.gov.ua:334/api/vac/getenergo");
         $data = json_decode($vacanties,true);
         
          $response = [
            'response'=>[
                    'success' => true,
                    'vacanties'=>[
                        'data'  => $data,
                    ]
            ]
        ];
        return response()->json($response, 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addVacancy(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateVacancy(Request $request)
    {
        //
    }

}

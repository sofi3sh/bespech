<?php

namespace App\Http\Controllers\HomeWork;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeWork\HomeWorkTeacher;
use App\Models\HomeWork\Studentdz;
use App\Models\HomeWork\File;

class HomeworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
          $home_work_user_id = request('user_id', null);
          $home_work_subject_id = request('subject_id', null);

          
          if($home_work_user_id || $home_work_subject_id){
              $home_work_teachers = HomeWorkTeacher::where('user_id', $home_work_user_id)
                                                          ->where('subject_id', $home_work_subject_id)
                                                          ->get();
          } else {
               $home_work_teachers = HomeWorkTeacher::all();
          }
        
         
         return response()->json($home_work_teachers, 200);
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
    public function addHomeWorkTiket(Request $request)
    {
        dd("addHomeWorkTiket");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addHomeWorkFile(Request $request)
    {
        dd("addHomeWorkFile");
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getHomeWorkFile(Request $request)
    {
       $home_work_files = Studentdz::all();
       $files = File::all();
       $result = [
           $home_work_files,
           $files
           ];
       
         return response()->json($result, 200);
    }
}
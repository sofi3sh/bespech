<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
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
      //  dd($token,  $api_key);
       
        
        if($api_key == "d4d12fb2a814682bbdc0cba801cb5919edf1273a61007d82ca0bf331c59d7986"){
        $profiles = Profile::all();
        
        $response = [
            'response'=>[
                 'success' => true,
                 'profiles'=>[
                     'localizationId' => 1, // id мови укр
                      'data'  => $profiles,
                     ]
                ]
        ];
        
        return response()->json($response, 200);
        
        } else {
             $response = [
            'response'=>[
                 'success' => false,
                 'error' => 404
                ]
        ];
            
            return response()->json($response, 404);
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

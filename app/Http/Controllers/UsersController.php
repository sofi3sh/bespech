<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->input('id');
             
            $user =  User::find($id);

            if($user){
                 $data = [
                            "id"=>$user->id,
                            "category_id"=> $user->category_id,
                            "banned"=> ($user->banned == 0) ? false : true,
                            "banReason"=> $user->banReason,
                            "email"=>$user->email,
                            "token"=> $user->token,
                            "created_at"=> $user->created_at,
                            "updated_at"=> $user->updated_at,
                         ];
                    } else {
                        $data = [];
                    } 
        } else {
            
               $users =  User::all();
             
               if(count($users)>0){
                   foreach ($users as $user){
                       $data [] = [
                                "id"=>$user->id,
                                "category_id"=> $user->category_id,
                                "banned"=> ($user->banned == 0) ? false : true,
                                "banReason"=> $user->banReason,
                                "email"=>$user->email,
                                "token"=> $user->token,
                                "created_at"=> $user->created_at,
                                "updated_at"=> $user->updated_at,
                           ];
                   }
               } else {
                        $data = [];
               } 
        }
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            if($request->has('id')) {
                if ($request->has('update')) {
                       $id = $request->input('id');
                       $user = User::find($id);

                      $user->category_id = $request->category_id;
                      $user->banned = $request->banned;
                      $user->banReason = $request->banReason;
                      $user->email = $request->email;
                      $user->password =  bcrypt($request->password);
                      $user->save();
                      return response()->json(200);
                }
  
                 if ($request->has('delete')) {
                      $id = $request->input('id');
                      User::where('id', $id)->delete();
                      
                      return response()->json(200);
                }
            } else {
                    
                  $user = [
                            "category_id"=> $request->category_id,
                            "banned"=> false,
                            "banReason"=> '',
                            "email"=>$request->email,
                            "password"=>bcrypt($request->password),
                          ];             
         
                  $user = User::create($user);
                  
                  return response()->json(200);
            }
    }

}

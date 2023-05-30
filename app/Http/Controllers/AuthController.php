<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;



class AuthController extends BaseController
{
    use AuthenticatesUsers;

    public function signin(Request $request)
    {
        $this->middleware('guest')->except('logout');

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $authUser = Auth::user();
            $accessToken = $authUser->createToken('token_name')->plainTextToken;


            $response = [
                'response' => [
                    'success' => true,
                    'user' => [
                        'localizationId' => 1,
                        'data' => $authUser,
                    ]
                ],
                'access_token' => $accessToken,
            ];

            return response()->json($response, 200);

        } else {
            $response = [
                'response' => [
                    'success' => false,
                    'error' => 404
                ]
            ];
            return response()->json($response, 404);
        }
    }


    public function signup(Request $request)
    {

        $validator = Validator::make($request->all(),$this->validateRules()['authorization'], $this->bindMessages());

        if ($validator->fails()) {
            $errors = $validator->errors();
            $response = [
                'response' => [
                    'success' => false,
                    'errors' => $errors,
                ],
            ];
            return response()->json($response, 422);
        }

        $data = $request->all();

        $user = $this->create($data);
        $success['token'] = $user->createToken('api-key')->plainTextToken;
        $success['name'] = $user->name;
        $usering = DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->value('token');

        if ($user) {
            $response = [
                'response' => [
                    'success' => true,
                    'user' => [
                        'localizationId' => 1,
                        'data' => $user,
                    ],
                ],
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'response' => [
                    'success' => false,
                    'error' => 404,
                ],
            ];
            return response()->json($response, 404);
        }
    }

    public function create(array $data)
    {
        return User::create([
            'category_id' => $data["categoryId"],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'token' => Str::random(70),
        ]);

    }


}

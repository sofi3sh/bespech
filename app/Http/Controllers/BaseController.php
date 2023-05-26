<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateApikey($api_key){
        if($api_key != "d4d12fb2a814682bbdc0cba801cb5919edf1273a61007d82ca0bf331c59d7986"){
            $response = [
                'response'=>[
                    'success' => false,
                    'error' => 415,
                    'message'=>"Not found api-key"
                ]
            ];
            return [
                'response' => $response,
                'code'=> 415
            ];
        }else{
            return false;
        }
    }

    public function validateUserToken($userId, $categoryId = 0, $correctCategoryId = 0){
        // dd($userId);
        $categoryId = $categoryId ? $categoryId->category_id : 0;
        if(!$userId || $categoryId != $correctCategoryId){
            $response = [
                'response'=>[
                    'success' => false,
                    'error' => 401,
                    'message'=>"Incorrect_token"
                ]
            ];
            return [
                'response' => $response,
                'code'=> 401
            ];
        }else{
            return false;
        }
    }

    public function validateRules(): array{
        return $messages = [
            'authorization'=>[
                'categoryId' => ['required'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'password_confirmation' => 'required|same:password',
            ]
        ];
    }

    public function bindMessages(): array{
        return $messages = [
            'name.required' => "The name field is empty",
            'lastName.required' => "The lastName field is empty",
            'age.required' => "The age field is empty",
            'age.integer' => "The age field is not integer",
            'age.min' => "The age field less than 99",
            'age.max' => "The age field exceeds 99",
            'email.required' => "The email field is empty",
            'email.email' => "Email field entered is incorrect",
            'email.unique' => "Email is already in used",
            'password_confirmation.same' => "Passwords do not match",
            'address.required' => "The address field is empty",
            'phone.required' => 'The phone field is empty',
            'phone.numeric' => 'The phone field must contain only numbers',
            'phone.digits_between' => 'The phone field must contain 10-12 digits',

        ];
    }


    public function sendResponce($response, $code){
        return response()->json($response, $code);
    }

}


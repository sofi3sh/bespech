<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }
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
    
    
    public function bindMesages(){
        return $messages = [
            'name.required' => "The name field is empty",
            'lastName.required' => "The lastName field is empty",
            'age.required' => "The age field is empty",
            'age.integer' => "The age field is not integer",
            'age.min' => "The age field less than 99",
            'age.max' => "The age field exceeds 99",
            'email.required' => "The email field is empty",
            'email.email' => "Email field entered is incorrect",
            'address.required' => "The address field is empty",
            'phone.required' => 'The phone field is empty',
            'phone.numeric' => 'The phone field must contain only numbers',
            'phone.digits_between' => 'The phone field must contain 10-12 digits',
        ];
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function sendValidationErrorDelete($error, $errorMessages = [], $code = 422){
    	$response = [
    	   // 'response'=>[
    	        'success' => false,
                'error'=> $code,
                'message' => $error,
    	   // ]
	        
        ];
        if(!empty($errorMessages)){
            $errorMessages = json_decode(json_encode($errorMessages), true);
         
         $srt_error = '';
         foreach ($errorMessages as $values){
             foreach ($values as $value){
                 $srt_error .= $value.'. ';
             }
         }
         $response['info'] =  $srt_error;
            
        }
        return response()->json($response, $code);
    }
    
    public function sendValidationError($error, $errorMessages = [], $code = 422){
    	$response = [
    	    'response'=>[
    	        'success' => false,
                'error'=> $code,
                'message' => $error,
    	    ]
        ];
        if(!empty($errorMessages)){
            $errorMessages = json_decode(json_encode($errorMessages), true);
         
         $srt_error = '';
         foreach ($errorMessages as $values){
             foreach ($values as $value){
                 $srt_error .= $value.'. ';
             }
         }
         $response['response']['info'] = $srt_error;
            
        }
        return response()->json($response, $code);
    }
    
    //delete
    public function tokenNotFound($errorMessage = 'incorrect token', $code = 404){
        $response = [
    	    'response'=>[
    	        'message'=>$errorMessage,
                'success' => false,
                'error' => $code
            ]
    	];
    	
    	return response()->json($response, $code);
    }
    //delete
    
    //delete
    public function tokenDoesNotBelongToThisCategory($errorMessage = 'token does not belong to this category', $code = 404){
    	$response = [
    	    'response'=>[
    	        'message'=>$errorMessage,
                'success' => false,
                'error' => $code
            ]
    	];
    	return response()->json($response, $code);
    }
    //delete
    
    //delete
    public function invalidApiKey($errorMessage = 'incorrect api-key', $code = 404){
    	$response = [
    	    'response'=>[
    	        'message'=>$errorMessage,
                'success' => false,
                'error' => $code
            ]
    	];
    	return response()->json($response, $code);
    }
    //delete
}


<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Doc\DocApiController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/doc-api', 'App\Http\Controllers\Doc\DocapiController@index');
// Auth::routes();

Route::get('index', 'LocalizationController@index');
Route::get('change/lang', 'LocalizationController@lang_change')->name('LangChange');


// Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login'); 
// Route:: post('login', 'App\Http\Controllers\AuthController@signin')->name('signin');
// Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout'); 


// //Registration Routes...
// Route::get('register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register'); 
// Route::post('register', 'App\Http\Controllers\AuthController@signup')->name('register');//signup




// Password Reset Routes...
Route::get('password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');

Route::post('password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

Route::get('password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.reset');



Route::get('/access?token={token}', 'App\Http\Controllers\HomeController@index')->name('/access?token=');
//Route::get('/doc-api', 'App\Http\Controllers\Docapi\DocApiController@index');
// Route::get('/categories', [CategoryController::class, 'index'])->name('categories');







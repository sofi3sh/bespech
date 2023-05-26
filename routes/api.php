<?php

use App\Http\Controllers\Api\Content\PartnersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Content\AdminWhyModuleController;
use App\Http\Controllers\Api\Content\PatrnersModule;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



/* AndriiDev */


Route::get('/why-module', [AdminWhyModuleController::class, 'index']); // метод виводу Всього

Route::get('/admin-why-module-advantages', [AdminWhyModuleController::class, 'getAdvantagesWithNames']); // метод виводу преваг
Route::post('/advantages', [AdminWhyModuleController::class, 'storeAdvantage']); // метод додає переваги в табличку
Route::put('/advantages/{id}', [AdminWhyModuleController::class, 'updateAdvantage']); //редагує переваги
Route::delete('/advantages/{id}', [AdminWhyModuleController::class, 'deleteAdvantage']); // видаляє переваги


Route::resource( '/admin-partners', PartnersController::class);


// //login Routes...
Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route:: post('login', 'App\Http\Controllers\AuthController@signin')->name('signin');
Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
// //Registration Routes...
Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@getCategory')->name('register');
Route::post('/register', 'App\Http\Controllers\AuthController@signup')->name('register');//signup

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

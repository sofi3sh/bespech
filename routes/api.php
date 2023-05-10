<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\VersionController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\VacancyController;
use App\Http\Controllers\Api\IssavedController;
use App\Http\Controllers\Api\FilterParamsController;
use App\Http\Controllers\Api\UserFilterConrtoller;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\CvEmployee\CvEmployeeController;
use App\Http\Controllers\HomeWork\HomeworkController;


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
Route::post('login', [AuthController::class, 'signin'])->name('login');
Route::post('register', [AuthController::class, 'signup'])->name('register');


Route::get('categories', [CategoryController::class, 'index']);
Route::get('category', [CategoryController::class, 'show']);
Route::get('config', [VersionController::class, 'index']);

Route::get('language', [LanguageController::class, 'index']);
Route::apiResource('users',UsersController::class);
Route::get('homeWork',[HomeworkController::class, 'index']);
Route::post('homeWork',[HomeworkController::class, 'addHomeWorkTiket']);
Route::get('homeWorkFile',[HomeworkController::class, 'getHomeWorkFile']);
Route::post('homeWorkFile',[HomeworkController::class, 'addHomeWorkFile']);



Route::apiResource('profileEducation',EducationController::class);
Route::apiResource('profileEmployee', EmployeeController::class);
Route::apiResource('profileCompany', CompanyController::class);
Route::apiResource('vacancy', VacancyController::class);
Route::apiResource('isSaved', IssavedController::class);


Route::apiResource('filterParams', FilterParamsController::class);
Route::apiResource('userFilter', UserFilterConrtoller::class);

Route::apiResource('employeeCv', CvEmployeeController::class);
Route::apiResource('region', RegionController::class);
Route::apiResource('city', CityController::class);






// Route::get('profileEducation', [EducationController::class, 'index']);
// Route::get('profileEmployee', [EmployeeController::class, 'index']);
// Route::get('profileCompany', [CompanyController::class, 'index']);

// Route::patch('updateProfileEducation', [EducationController::class, 'update']);
// Route::patch('updateProfileEmployee', [EmployeeController::class, 'update']);
// Route::patch('updateProfileCompany', [CompanyController::class, 'update']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

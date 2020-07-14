<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('user', 'API\UserController');
Route::post('/user/active/{user}', 'API\UserController@active');
Route::post('/user/inactive/{user}', 'API\UserController@inactive');
Route::get('/profile', 'API\UserController@profile');
Route::patch('/updateProfile', 'API\UserController@updateProfile');

Route::apiResource('category', 'API\CategoryController');
Route::DELETE('/category/deleteSelected/{id}', 'API\CategoryController@deleteSelected');

Route::apiResource('company', 'API\CompanyController');
Route::get('/findCompany', 'API\CompanyController@search');
Route::get('event', 'API\EventController@index');
Route::get('dashboard', 'API\DashboardController@index');

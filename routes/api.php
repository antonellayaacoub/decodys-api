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

Route::group(
    [
        'prefix' => 'user',
        'namespace' => 'User',
    ],
    function () {
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        
        Route::post("patient/add", "PatientController@addPatients");
        Route::get("patient/get-all/{token}/{pagination?}", "PatientController@getPaginatedData");
        Route::post("patient/update/{id}", "PatientController@editSingleData");
        Route::post("patient/delete/{id}", "PatientController@deletePatients");
        Route::get("patient/get-single/{id}", "PatientController@getSingleData");
        Route::get("patient/search/{search}/{pagination?}", "PatientController@searchData");

        Route::post("test/add", "TestController@addtests");
        Route::get("test/get-all/{patient_id}/{pagination?}", "TestController@getPaginatedData");
        Route::post("test/update/{id}", "TestController@editSingleData");
        Route::post("test/delete/{id}", "TestController@deletetests");
        Route::get("test/get-single/{id}", "TestController@getSingleData");

        Route::post("miniTest/add", "MiniTestController@addMiniTests");
        Route::get("miniTest/get-all/{test_id}/{pagination?}", "MiniTestController@getPaginatedData");
        Route::post("miniTest/update/{id}", "MiniTestController@editSingleData");
        Route::post("miniTest/delete/{id}", "MiniTestController@deleteMiniTests");
        Route::get("miniTest/get-single/{id}", "MiniTestController@getSingleData");
    }
);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Department
Route::apiResource('departments','DepartmentController');
Route::delete('dep/{id}','DepartmentController@forceDelete');

//Position
Route::apiResource('positions','PositionController');

//Employee
Route::apiResource('employees','EmployeeController');
Route::delete('employees/forceDelete/{id}','EmployeeController@forceDelete');
Route::post('employees/search','EmployeeController@search');

Route::get('EmployeesExport', 'EmployeeController@fileExport');
// Route::post('excel', 'EmployeeController@excel')->name('export_excel.excel');

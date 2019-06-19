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

//Retrieve Total Used Storage Space
Route::get('file/space', 'FileController@getStorageSpace');

//Get List Of Stored Files
Route::get('file/all', 'FileController@getAllFiles');

//Download File
Route::get('file/{fileName}', 'FileController@downloadFile');

//Store File
Route::post('file', 'FileController@uploadFile');

//Delete File
Route::delete('file/{fileName}', 'FileController@deleteFile');








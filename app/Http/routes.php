<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('welcome');
    })->middleware('guest');

    Route::get('/call', function () {
        return view('sip.sip_content');
    })->middleware('auth');

    Route::get('/test', 'TaskController@test')->middleware('auth');

    Route::get('/tasks/{id?}', 'TaskController@index');

    Route::get('/task/success/{id}', 'TaskController@success');
    Route::get('/task/defer/{id}', 'TaskController@defer');
    Route::get('/task/fail/{id}/{fail_status_id}', 'TaskController@fail');
    Route::get('/task/notexist/{id}', 'TaskController@notexist');

    Route::post('/task', 'TaskController@store');
    Route::delete('/task/{task}', 'TaskController@destroy');

    Route::auth();

});

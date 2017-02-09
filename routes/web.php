<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/pet', 'PetController@index');
Route::get('/pet/all', 'PetController@all');
Route::get('/pet/create', 'PetController@create');
Route::post('/pet', 'PetController@store');
Route::get('/pet/modify', 'PetController@modify');
Route::get('/pet/info/{id}', 'PetController@info');
Route::get('/pet/edit/{id}', 'PetController@edit');

Route::get('/user', 'UserController@index');
Route::get('/user/edit/{id}', 'UserController@edit');
Route::post('/user/update', 'UserController@update');
Route::get('/user/create', 'UserController@create');
Route::get('/user/info', 'UserController@info');

Route::get('interface/getchuncai', 'InterfaceController@getChuncai');
Route::get('interface/getnotice', 'InterfaceController@getNotice');
Route::get('interface/measurements', 'InterfaceController@measurements');
Route::get('interface/package', 'InterfaceController@package');
Route::get('interface/talkcon', 'InterfaceController@talkcon');
Route::get('interface/eat', 'InterfaceController@eat');
Route::get('interface/carrying', 'InterfaceController@carrying');
Route::get('interface/constellation', 'InterfaceController@constellation');
Route::get('interface/calendar', 'InterfaceController@calendar');
Route::get('interface/oneiromancy', 'InterfaceController@oneiromancy');
Route::get('interface/mission', 'InterfaceController@mission');
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
Route::get('/plot', 'HomeController@plot');


Route::group(['prefix' => 'pet'], function () {
    Route::get('/', 'PetController@index');
    Route::get('all', 'PetController@all');
    Route::get('create', 'PetController@create');
    Route::post('pet', 'PetController@store');
    Route::get('modify', 'PetController@modify');
    Route::get('info/{id}', 'PetController@info');
    Route::get('edit/{id}', 'PetController@edit');
    Route::get('updateConfig', 'PetController@updateConfig');
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/', 'UserController@index');
    Route::get('edit/{id}', 'UserController@edit');
    Route::post('update', 'UserController@update');
    Route::get('create', 'UserController@create');
    Route::get('info', 'UserController@info');
    Route::get('getUser/{id}', 'UserController@getUser');
});

Route::get('/reset', 'UserController@reset');
Route::post('/reset', 'UserController@postReset');

Route::group(['prefix' => 'interface'], function () {
    Route::get('getchuncai', 'InterfaceController@getChuncai');
    Route::get('getnotice', 'InterfaceController@getNotice');
    Route::get('measurements', 'InterfaceController@measurements');
    Route::get('package', 'InterfaceController@package');
    Route::get('talkcon', 'InterfaceController@talkcon');
    Route::get('eat', 'InterfaceController@eat');
    Route::get('carrying', 'InterfaceController@carrying');
    Route::get('constellation', 'InterfaceController@constellation');
    Route::get('calendar', 'InterfaceController@calendar');
    Route::get('oneiromancy', 'InterfaceController@oneiromancy');
    Route::get('mission', 'InterfaceController@mission');
});

Route::group(['prefix' => 'event'], function () {
    Route::get('/', 'EventController@index');
    Route::post('/', 'EventController@store');
    Route::get('edit/{id}', 'EventController@edit');
    Route::get('create', 'EventController@create');
    Route::post('update', 'EventController@update');
    Route::get('delete/{id}', 'EventController@delete');
    Route::get('modify', 'EventController@modify');
});

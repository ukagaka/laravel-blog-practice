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
})->middleware(['auth']);

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/home', 'HomeController@index');

Route::get('/guba', 'GubaController@index');
Route::post('/guba', 'GubaController@store');
Route::get('/guba/edit/{id}', 'GubaController@edit');
Route::get('/guba/create', 'GubaController@create');
Route::post('/guba/update', 'GubaController@update');
Route::get('/guba/delete/{id}', 'GubaController@delete');
Route::get('/guba/recommend', 'GubaController@recommend');
Route::get('/guba/modify', 'GubaController@modify');


Route::get('/post', 'PostController@index');
Route::post('/post', 'PostController@store');
Route::get('/post/edit/{id}', 'PostController@edit');
Route::get('/post/create', 'PostController@create');
Route::post('/post/update', 'PostController@update');
Route::get('/post/delete/{id}', 'PostController@delete');
Route::get('/post/modify', 'PostController@modify');
Route::get('/post/audited', 'PostController@audited');
Route::get('/post/cancel/{id}', 'PostController@cancel');
Route::get('/post/deljp', 'PostController@deljp');
Route::get('/post/add', 'PostController@add');
Route::get('/post/recommend', 'PostController@recommend');
Route::get('/post/avatar', 'PostController@avatar');

Route::get('/replay', 'ReplayController@index');
Route::get('/report', 'ReplayController@report');
Route::get('/replay/delete/{id}', 'ReplayController@delete');
Route::get('/replay/cancel/{id}', 'ReplayController@cancel');
Route::get('/replay/edit/{id}', 'ReplayController@edit');
Route::post('/replay/update', 'ReplayController@update');
Route::get('/replay/modify', 'ReplayController@modify');

Route::get('/user', 'UserController@index');
Route::post('/user', 'UserController@store');
Route::get('/user/edit/{id}', 'UserController@edit');
Route::get('/user/create', 'UserController@create');
Route::post('/user/update', 'UserController@update');
Route::get('/reset', 'UserController@reset');
Route::post('/reset', 'UserController@postReset');

Route::get('/user/auth', 'UserController@auth');
Route::get('/user/authdel/{id}', 'UserController@authdel');
Route::get('/user/freeze/{id}', 'UserController@freeze');


Route::get('/recomgro', 'RecomgroController@index');
Route::post('/recomgro', 'RecomgroController@store');
Route::get('/recomgro/create', 'RecomgroController@create');
Route::get('/recomgro/edit/{id}', 'RecomgroController@edit');
Route::post('/recomgro/update', 'RecomgroController@update');
Route::get('/recomgro/delete/{id}', 'RecomgroController@delete');

Route::get('/tag', 'TagController@index');
Route::get('/tag/cancel/{id}', 'TagController@cancel');
Route::get('/tagno', 'TagController@index2');
Route::get('/tag/delete/{id}', 'TagController@delete');

Route::get('/recomcon', 'RecomconController@index');
Route::post('/recomcon', 'RecomconController@store');
Route::get('/recomcon/create', 'RecomconController@create');
Route::get('/recomcon/edit/{id}', 'RecomconController@edit');
Route::post('/recomcon/update', 'RecomconController@update');
Route::get('/recomcon/delete/{id}', 'RecomconController@delete');
Route::get('/recomcon/upord', 'RecomconController@upord');

Route::get('/nowords', 'NowordsController@index');
Route::post('/nowords', 'NowordsController@store');
Route::get('/nowords/create', 'NowordsController@create');
Route::get('/nowords/delete/{id}', 'NowordsController@delete');


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
Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::get('index','IndexController@index');
    Route::get('info','IndexController@info');
    Route::get('quit','IndexController@quit');
    Route::any('pass','IndexController@pass');
    Route::post('cate/changeorder','CategoryController@changeOrder');

    Route::resource('category','CategoryController');
    Route::resource('article','ArticleController');
    Route::any('upload','CommonController@upload');
});
Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::any('admin/login','Admin\LoginController@login');
    Route::get('admin/code','Admin\LoginController@code');
});

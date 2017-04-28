<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|


Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/','StaticPagesController@home'); //url '/'以get方式发出的请求将有StaticPagesController控制器中的home方法处理;
Route::get('/help','StaticPagesController@help');
Route::get('/about','StaticPagesController@about');

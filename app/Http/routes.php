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
Route::get('/','StaticPagesController@home')->name('home'); //url '/'以get方式发出的请求将有StaticPagesController控制器中的home方法处理;
Route::get('/help','StaticPagesController@help')->name('help');
Route::get('/about','StaticPagesController@about')->name('about');
// 用户登录;
get('signup','UsersController@create')->name('singup');// 路由定义简写格式;
/**
/*
*resource 方法定义用户资源路由;Laravel 遵从 RESTful 架构的设计原则，
*将数据看做一个资源，由 URI 来指定资源。
*对资源进行的获取、创建、修改和删除操作，
*分别对应 HTTP 协议提供的 GET、POST、PATCH 和 DELETE 方法
*/
resource('users','UsersController');
/*以上定义等同于
get('/users', 'UsersController@index')->name('users.index');
get('/users/{id}', 'UsersController@show')->name('users.show');
get('/users/create', 'UsersController@create')->name('users.create');
post('/users', 'UsersController@store')->name('users.store');
get('/users/{id}/edit', 'UsersController@edit')->name('users.edit');
patch('/users/{id}', 'UsersController@update')->name('users.update');
delete('/users/{id}', 'UsersController@destroy')->name('users.destroy');
*/
get('login','SessionsController@create')->name('login');//登陆
post('login','SessionsController@store')->name('login');//记忆登陆账户;
delete('logout','SessionsController@destroy')->name('logout');//退出登陆;

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
*/

Route::get('/', function () {
    return view('welcome');
});
//后台登陆
Route::resource('/admin/login','Admin\LoginController@login');
//获取验证码
Route::get('/admin/yzm','Admin\LoginController@yzm');
//后台首页
Route::get('/admin/index','Admin\LoginController@index');
<<<<<<< HEAD

//前台首页
Route::resource('/home/index','Home\IndexController');
=======
//后台欢迎页
Route::get('/admin/welcome','Admin\LoginController@welcome');

Route::group(['middleware' => 'login'],function(){
	
});
>>>>>>> f5221d097dcec58b61ff2bc906c621b08ee2c44f

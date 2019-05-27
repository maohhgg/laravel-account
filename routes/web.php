<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function ($router) {
    // 管理员登录注销
    $router->get('login', 'Auth\LoginController@showLogin')->name('admin.login');
    $router->post('login', 'Auth\LoginController@login');
    $router->post('logout', 'Auth\LoginController@logout');

    // 管理员账户更改密码
    $router->get('forgot', 'Auth\ResetPasswordController@showForgot')->name('admin.forgot');
    $router->post('forgot', 'Auth\ResetPasswordController@forgot');

    $router->get('/', 'AdminController@index')->name('admin.index');
    $router->get('/index', 'AdminController@index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

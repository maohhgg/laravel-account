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


Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin', 'namespace' => 'Admin'], function ($router) {

    // 后台单页面
    $router->get('/dash', 'HomeController@index');
    $router->get('/', 'HomeController@index')->name('admin');

    Route::prefix('users')->group(function ($router) {
        $router->get('/', 'UsersController@index')->name('admin.users');
        $router->get('create', 'UsersController@showCreateForm')->name('admin.users.create');
        $router->post('create', 'UsersController@save');
        $router->get('update/{id}', 'UsersController@updateForm')->name('admin.users.update');
        $router->post('save', 'UsersController@update')->name('admin.users.save');
        $router->post('delete', 'UsersController@deleteId')->name('admin.users.delete');;
    });

    Route::prefix('admins')->group(function ($router) {
        $router->get('/', 'AdminsController@index')->name('admin.admins');
        $router->get('create', 'AdminsController@showCreateForm')->name('admin.admins.create');
        $router->post('create', 'AdminsController@save');
        $router->get('update/{id}', 'AdminsController@updateForm')->name('admin.admins.update');
        $router->post('save', 'AdminsController@updateData')->name('admin.admins.save');
        $router->post('delete', 'AdminsController@deleteId')->name('admin.admins.delete');;
    });

    Route::prefix('data')->group(function ($router) {
        $router->get('/', 'DataController@index')->name('admin.data');
        $router->get('create/{id?}', 'DataController@createForm')->name('admin.data.create');
        $router->post('create', 'DataController@create');
        $router->get('update/{id}', 'DataController@updateForm')->name('admin.data.update');
        $router->post('save', 'DataController@update')->name('admin.data.save');
        $router->post('delete', 'DataController@deleteId')->name('admin.data.delete');;
    });

    Route::prefix('change')->group(function ($router) {
        $router->get('/', 'ChangeController@index')->name('admin.change');
        $router->post('save', 'ChangeController@updateData')->name('admin.change.save');
        $router->post('delete', 'ChangeController@deleteId')->name('admin.change.delete');;
    });

    Route::prefix('autocomplete')->group(function ($router) {
        $router->get('name', 'UsersController@autocomplete')->name('users.autocomplete');
    });

});


// 后台登录
Route::prefix('admin')->namespace('Admin\Auth')->group(function ($router) {
    // 管理员登录注销
    $router->get('login', 'LoginController@showLogin')->name('admin.login');
    $router->post('login', 'LoginController@login');
    $router->get('logout', 'oginController@logout')->name('admin.logout');
    $router->post('logout', 'LoginController@logout');

    // 管理员账户更改密码
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');

});

// 前台登录
Auth::routes();

Route::middleware('auth')->group(function ($router) {
    $router->get('/','HomeController@index')->name('home');
    $router->get('data/history','DataController@history')->name('data.history');
});

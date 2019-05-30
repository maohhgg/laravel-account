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

// 后台但页面
Route::prefix('admin')->namespace('Admin')->group(function ($router) {
    $router->get('/', 'HomeController@index')->name('admin');
});


Route::prefix('admin/users')->namespace('Admin')->group(function ($router) {
    $router->get('/', 'UsersController@index')->name('admin.users');

    $router->get('create', 'UsersController@showCreateForm')->name('admin.users.create');
    $router->post('create', 'UsersController@save');
});

Route::prefix('admin/admins')->namespace('Admin')->group(function ($router) {
    $router->get('/', 'AdminsController@index')->name('admin.admins');

    $router->get('create', 'AdminsController@showCreateForm')->name('admin.admins.create');
    $router->post('create', 'AdminsController@save');
});

Route::prefix('admin/data')->namespace('Admin')->group(function ($router) {
    $router->get('/', 'DataController@index')->name('admin.data');
    $router->get('create', 'DataController@createForm')->name('admin.data.create');
});

Route::prefix('admin/change')->namespace('Admin')->group(function ($router) {
    $router->get('/', 'ChangeController@index')->name('admin.change');
});

Route::prefix('autocomplete')->namespace('Admin')->group(function ($router) {
    $router->get('name', 'UsersController@autocomplete')->name('users.autocomplete');
});




// 后台登录
Route::prefix('admin')->namespace('Admin\Auth')->group(function ($router) {
    // 管理员登录注销
    $router->get('login', 'LoginController@showLogin')->name('admin.login');
    $router->post('login', 'LoginController@login');
    $router->get('logout', 'oginController@logout')->name('admin.logout');
    $router->post('logout', 'LoginController@logout');

    // 管理员账户更改密码
    $router->get('forgot', 'ResetPasswordController@showForgot')->name('admin.forgot');
    $router->post('forgot', 'ResetPasswordController@forgot');

});

// 后台登录
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

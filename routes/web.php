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

    // 管理员修改自己帐号
    $router->get('settings', 'AdminsController@settingForm')->name('admin.settings');
    $router->get('password', 'AdminsController@passwordForm')->name('admin.password');
    $router->post('password/update', 'AdminsController@updatePassword')->name('admin.password.update');


    Route::prefix('users')->group(function ($router) {
        // 展示页面
        $router->get('/', 'UsersController@index')->name('admin.users');
        $router->get('create', 'UsersController@createForm')->name('admin.users.create');
        $router->get('update/{id}', 'UsersController@updateForm')->name('admin.users.update');

        // post 处理页面
        $router->post('create', 'UsersController@createWithNamePassword');
        $router->post('save', 'UsersController@updateUser')->name('admin.users.save');
        $router->post('delete', 'UsersController@deleteId')->name('admin.users.delete');
    });

    Route::prefix('admins')->group(function ($router) {
        // 展示页面
        $router->get('/', 'AdminsController@index')->name('admin.admins');
        $router->get('create', 'AdminsController@createForm')->name('admin.admins.create');
        $router->get('update/{id}', 'AdminsController@updateForm')->name('admin.admins.update');

        // post 处理页面
        $router->post('create', 'AdminsController@createWithNamePassword');
        $router->post('save', 'AdminsController@updateAdmin')->name('admin.admins.save');
        $router->post('delete', 'AdminsController@deleteId')->name('admin.admins.delete');
    });

    Route::prefix('data')->group(function ($router) {

        $router->get('/{id?}', 'DataController@display')->name('admin.data');
        $router->get('create/{id?}', 'DataController@createForm')->name('admin.data.create');
        $router->get('update/{id}', 'DataController@updateForm')->name('admin.data.update');

        $router->post('add', 'DataController@create');
        $router->post('save', 'DataController@update')->name('admin.data.save');
        $router->post('delete', 'DataController@deleteId')->name('admin.data.delete');;
    });

    Route::prefix('change')->group(function ($router) {
        // 展示页面
        $router->get('/', 'ChangeController@index')->name('admin.change');

        // post 处理页面
        $router->post('save', 'ChangeController@updateAction')->name('admin.change.save');
        $router->post('create', 'ChangeController@create')->name('admin.change.create');
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
    $router->get('logout', 'LoginController@logout')->name('admin.logout');

    $router->post('login', 'LoginController@login');
    $router->post('logout', 'LoginController@logout');

});

// 前台登录
Auth::routes();

Route::middleware('auth')->group(function ($router) {

    $router->get('/','HomeController@index')->name('home');
    $router->get('data/history','DataController@history')->name('data.history');

    // 用户修改自己帐号
    $router->get('settings', 'Admin\UsersController@settingForm')->name('user.settings');
    $router->get('password', 'Admin\UsersController@passwordForm')->name('user.password');
    $router->post('password/update', 'Admin\UsersController@updatePassword')->name('user.password.update');
});

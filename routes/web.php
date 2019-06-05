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
    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->get('settings', 'HomeController@settingForm')->name('admin.settings');
    $router->post('config/save', 'HomeController@configSave')->name('admin.config.save');


    // 管理员修改自己帐号
    $router->get('password', 'AdminsController@passwordForm')->name('admin.password');
    $router->post('password/update', 'AdminsController@updatePassword')->name('admin.password.save');


    // 用户管理
    Route::prefix('users')->group(function ($router) {
        // 展示页面
        $router->get('/', 'UsersController@display')->name('admin.users');
        $router->get('create', 'UsersController@createForm')->name('admin.users.create');
        $router->get('update/{id}', 'UsersController@updateForm')->name('admin.users.update');

        // post 处理页面
        $router->post('add', 'UsersController@createWithNamePassword')->name('admin.users.add');
        $router->post('save', 'UsersController@updateUser')->name('admin.users.save');
        $router->post('delete', 'UsersController@deleteId')->name('admin.users.delete');
    });

    // 管理员管理
    Route::prefix('admins')->group(function ($router) {
        // 展示页面
        $router->get('/', 'AdminsController@display')->name('admin.admins');
        $router->get('create', 'AdminsController@createForm')->name('admin.admins.create');
        $router->get('update/{id}', 'AdminsController@updateForm')->name('admin.admins.update');

        // post 处理页面
        $router->post('add', 'AdminsController@createWithNamePassword')->name('admin.admins.add');
        $router->post('save', 'AdminsController@updateAdmin')->name('admin.admins.save');
        $router->post('delete', 'AdminsController@deleteId')->name('admin.admins.delete');
    });

    // 流水数据管理
    Route::prefix('data')->group(function ($router) {

        $router->get('/', 'DataController@display')->name('admin.data');
        $router->get('/user/{id?}', 'DataController@display')->name('admin.data.user');
        $router->get('/order/{order}', 'DataController@order')->name('admin.data.order');
        $router->get('create/{id?}', 'DataController@createForm')->name('admin.data.create');
        $router->get('update/{id}', 'DataController@updateForm')->name('admin.data.update');

        $router->post('add', 'DataController@create')->name('admin.data.add');
        $router->post('save', 'DataController@update')->name('admin.data.save');
        $router->post('delete', 'DataController@deleteId')->name('admin.data.delete');;
    });

    // 流水类型管理
    Route::prefix('change')->group(function ($router) {
        // 展示页面
        $router->get('/', 'ChangeController@display')->name('admin.change');

        // post 处理页面
        $router->post('add', 'ChangeController@create')->name('admin.change.add');
        $router->post('save', 'ChangeController@updateAction')->name('admin.change.save');
        $router->post('delete', 'ChangeController@deleteId')->name('admin.change.delete');;
    });

    // 每日汇总数据管理
    Route::prefix('collect')->group(function ($router) {
        // 展示页面
        $router->get('/', 'CollectController@display')->name('admin.collect');
        $router->get('create/{id?}', 'CollectController@createFrom')->name('admin.collect.create');
        $router->get('/user/{id?}', 'CollectController@display')->name('admin.collect.user');
        $router->get('/order/{order}', 'CollectController@order')->name('admin.collect.order');
        $router->get('update/{id}', 'CollectController@updateForm')->name('admin.collect.update');

        // post 处理页面
        $router->post('add', 'CollectController@create')->name('admin.collect.add');
        $router->post('save', 'CollectController@updateCollect')->name('admin.collect.save');
        $router->post('delete', 'CollectController@deleteId')->name('admin.collect.delete');;
    });

    // 订单数据管理
    Route::prefix('order')->group(function ($router) {
        // 展示页面
        $router->get('/', 'OrderController@display')->name('admin.order');
        $router->get('/user/{id?}', 'OrderController@display')->name('admin.order.user');
        $router->get('/order/{order}', 'OrderController@order')->name('admin.order.order');

        // post 处理页面
        $router->post('delete', 'OrderController@deleteId')->name('admin.order.delete');;
    });

    // 根据名称补全用户
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

    // 前台单页面
    $router->get('/','HomeController@index')->name('home');
    $router->get('data/history','DataController@history')->name('history');
    $router->get('data/collect','DataController@collect')->name('collect');
    $router->get('recharge','HomeController@recharge')->name('recharge');

    $router->post('recharge/submit','RechargeController@submit')->name('recharge.submit');
    // 充值成功回调地址
    $router->post('recharge/result/{token}','RechargeController@success')->name('recharge.success');

    // 用户修改自己帐号
    $router->get('settings', 'Admin\UsersController@settingForm')->name('settings');
    $router->get('password', 'Admin\UsersController@passwordForm')->name('password');
    $router->post('password/update', 'Admin\UsersController@updatePassword')->name('password.save');
});


// 充值异步处理页面
Route::post('/recharge/results','NobodyController@success')->name('recharge.results');

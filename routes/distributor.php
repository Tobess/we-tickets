<?php

/*
|--------------------------------------------------------------------------
| Web Routes For Distributor
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for distributor application. These
| routes are included by the web.php. Now create something great!
|
*/

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('dist-login');
Route::post('login', 'Auth\LoginController@login');
Route::any('logout', 'Auth\LoginController@logout')->name('dist-logout');

Route::middleware('auth:distributor')->group(function () {
    Route::get('/', function () {
        return view('apps.distributor.index');
    });
    // 分销商分销商品
    Route::get('items', 'Apps\Dist\Sale\DistController@getIndex');
    // 分销商销售订单
    Route::get('orders', 'Apps\Dist\Sale\OrderController@getIndex');
    // 创建分销商销售订单
    Route::get('orders/create', 'Apps\Dist\Sale\OrderController@getCreate');
    // 保存分销商销售订单
    Route::post('orders/create', 'Apps\Dist\Sale\OrderController@postCreate');
    // 删除分销商订单
    Route::get('orders/destroy/{id}', 'Apps\Dist\Sale\OrderController@getDestroy');

});
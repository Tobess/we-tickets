<?php

/*
|--------------------------------------------------------------------------
| Web Routes For Platform
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for platform application. These
| routes are included by the web.php. Now create something great!
|
*/

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::any('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::middleware('auth:platform')->group(function () {
    Route::get('/', function () {
        return view('apps.platform.index');
    });

    // 产品
    Route::prefix('product')->group(function () {
        // 类目列表
        Route::get('categories', 'Apps\Platform\Product\CategoryController@getIndex');
        // 类目详情
        Route::get('categories/profile/{id}', 'Apps\Platform\Product\CategoryController@getProfile');
        // 保存类目
        Route::post('categories/store', 'Apps\Platform\Product\CategoryController@postStore');
        // 删除类目
        Route::get('categories/destroy/{id}', 'Apps\Platform\Product\CategoryController@getDestroy');

        // 场馆列表
        Route::get('venue', 'Apps\Platform\Product\VenueController@getIndex');
        // 编辑场馆
        Route::get('venue/edit/{id}', 'Apps\Platform\Product\VenueController@getEdit')->name('venue-edit');
        // 保存场馆
        Route::post('venue/store', 'Apps\Platform\Product\VenueController@postStore')->name('venue-store');
        // 删除场馆
        Route::get('venue/destroy/{id}', 'Apps\Platform\Product\VenueController@getDestroy');

        // 商品管理
        Route::get('items', 'Apps\Platform\Product\ItemsController@getIndex');
        // 编辑商品
        Route::get('items/edit/{id}', 'Apps\Platform\Product\ItemsController@getEdit')->name('items-edit');
        // 保存商品
        Route::post('items/store', 'Apps\Platform\Product\ItemsController@postStore');
        // 删除商品
        Route::get('items/destroy/{id}', 'Apps\Platform\Product\ItemsController@getDelete');
        // 获得库存
        Route::get('items/stocks/{id}', 'Apps\Platform\Product\ItemsController@getProductStocks');

        // 供应商家
        Route::get('supplier', 'Apps\Platform\Product\SupplierController@getIndex');
        // 编辑供应商家
        Route::get('supplier/edit/{id}', 'Apps\Platform\Product\SupplierController@getEdit');
        // 保存供应商家
        Route::post('supplier/store', 'Apps\Platform\Product\SupplierController@postStore');
        // 删除供应商家
        Route::get('supplier/stop/{id}', 'Apps\Platform\Product\SupplierController@getStop');
    });

    // 销售
    Route::prefix('sale')->group(function () {
        // 分销商家
        Route::get('distributor', 'Apps\Platform\Sale\DistributorController@getIndex');
        // 编辑分销商家
        Route::get('distributor/edit/{id}', 'Apps\Platform\Sale\DistributorController@getEdit');
        // 保存分销商家
        Route::post('distributor/store', 'Apps\Platform\Sale\DistributorController@postStore');
        // 删除分销商家
        Route::get('distributor/stop/{id}', 'Apps\Platform\Sale\DistributorController@getStop');
        // 获得分销商品
        Route::get('dist-items', 'Apps\Platform\Sale\DistributorController@getDistProducts');
        // 添加分销商品
        Route::post('dist-items/store', 'Apps\Platform\Sale\DistributorController@postDistProduct');
        // 删除分销商品
        Route::get('dist-items/destroy/{id}', 'Apps\Platform\Sale\DistributorController@deleteDistProduct');

        // 销售订单
        Route::get('orders', 'Apps\Platform\Sale\OrderController@getIndex');
    });

    // 系统
    Route::prefix('system')->group(function () {
        Route::get('users', 'Apps\Platform\System\UserController@getIndex');
        Route::get('users/edit/{id}', 'Apps\Platform\System\UserController@getEdit');
        Route::post('users/store', 'Apps\Platform\System\UserController@postStore');
        Route::get('users/stop/{id}', 'Apps\Platform\System\UserController@getStop');
        Route::get('users/recovery/{id}', 'Apps\Platform\System\UserController@getRecovery');
        Route::get('users/destroy/{id}', 'Apps\Platform\System\UserController@getDestroy');
    });
});
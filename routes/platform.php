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
        Route::get('venue/edit/{id}', 'Apps\Platform\Product\VenueController@getEdit');
    });

    // 系统
    Route::prefix('system')->group(function () {
        Route::get('users', 'Apps\Platform\System\UserController@getIndex');
    });
});
<?php

/*
|--------------------------------------------------------------------------
| Web Routes For Supplier
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for supplier application. These
| routes are included by the web.php. Now create something great!
|
*/

Route::post('login', 'Apps\Supplier\AuthController@login');

Route::middleware('auth:supplier')->group(function () {
    Route::post('logout', 'Apps\Supplier\AuthController@logout');
    Route::post('profile', 'Apps\Supplier\AuthController@getSupplier');
});
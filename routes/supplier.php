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

Route::middleware(['jwt.token.refresh:supplier'])->group(function () {
    Route::post('logout', 'Apps\Supplier\AuthController@logout');
    Route::get('profile', 'Apps\Supplier\AuthController@getSupplier');
    route::get('search', 'Apps\Supplier\TicketController@getCheck');
    route::post('pick', 'Apps\Supplier\TicketController@postPick');
    route::get('history', 'Apps\Supplier\TicketController@getPickedTickets');
});
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'namespace' => 'API'
], function ($router) {

    Route::group([
        'middleware' => ['refresh', 'auth:api']
    ], function ($router) {

        Route::group([
            'middleware' => 'role:admin'
        ], function ($router) {

            Route::get('/users/{page?}/{perPage?}/{search?}', 'Users\UserController@getList');
            Route::patch('/order', 'Orders\OrderController@patch');
        });

        Route::group([
            'middleware' => 'admin.or:user'
        ], function ($router) {

            Route::get('/user/{id}/{lang?}', 'Users\UserController@get');
            Route::patch('/user', 'Users\UserController@patch');
        });

        Route::get('/order/{id}', 'Orders\OrderController@get')
            ->middleware('admin.or:order_owner');
    });
    
    Route::get('/products/{page?}/{perPage?}/{search?}', 'Products\ProductController@getList');
    Route::get('/order_statuses', 'OrderStatuses\OrderStatusController@getAll');
});

Route::group([
    'prefix' => 'auth',
    'namespace' => 'Auth'
], function ($router) {

    Route::group([
        'middleware' => ['refresh', 'auth:api']
    ], function ($router) {
        Route::post('/logout', 'AuthController@logout');
        Route::post('/me', 'AuthController@me');
    });

    Route::post('/login', 'AuthController@login');
});
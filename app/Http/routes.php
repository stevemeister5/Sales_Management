<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/user/search', ['uses' => 'UserController@searchUser', 'as' => 'search.user']);

    Route::get('/', ['uses' => 'BillController@create', 'as' => 'home']);

    Route::get('/home', ['uses' => 'BillController@create', 'as' => 'home']);

    Route::resource('bill', 'BillController');

    Route::resource('product', 'ProductController');
    Route::get('product/status/{id}', 'ProductController@changestatus')->name('product.changestatus');

    Route::resource('category', 'CategoryController', [
        'except' => ['destroy']
    ]);

    Route::delete('category/{category?}', 'CategoryController@destroy');
    Route::resource('order', 'OrderController');

    Route::resource('user', 'UserController');

    Route::group(['prefix' => 'statistic'], function () {

        Route::get('/weekly', [
            'uses' => 'StatisticController@daily',
            'as' => 'statistic.daily'
        ]);

        Route::get('/monthly', [
            'uses' => 'StatisticController@monthly',
            'as' => 'statistic.monthly'
        ]);

        Route::get('/quarterly', [
            'uses' => 'StatisticController@quarterly',
            'as' => 'statistic.quarterly'
        ]);
    });

    Route::get('api/product', function () {
        return Response::json(\App\Models\Product::all());
    });
});

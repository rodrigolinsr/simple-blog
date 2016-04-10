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

Route::group(['middlewareGroups' => ['web']], function () {
    Route::auth();

    Route::get('/', 'IndexController@index');

    Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'Admin'], function () {
      // Dashboard routes
      Route::get('/', 'DashboardController@index');
      Route::post('/dashboard/settings', 'DashboardController@saveSettings');
      Route::post('/dashboard/post/draft', 'DashboardController@savePostAsDraft');
    });
});

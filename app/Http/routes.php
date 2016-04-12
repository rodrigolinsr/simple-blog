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
    Route::get('/home', function() {
      return redirect('/');
    });

    Route::get('/post/{id}', 'IndexController@viewPost');
    Route::post('/post/{id}/comments/add/', 'IndexController@postComment');

    Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'Admin'], function () {
      // Dashboard routes
      Route::get('/', 'DashboardController@index');
      Route::post('dashboard/settings', 'DashboardController@saveSettings');
      Route::post('dashboard/post/draft', 'DashboardController@savePostAsDraft');

      // Posts routes
      Route::resource('posts', 'PostsController');

      // Users routes
      Route::resource('users', 'UsersController');

      // Comments routes
      Route::get('comments', 'CommentsController@index');
      Route::get('comments/approve/{id}', 'CommentsController@approve');
      Route::get('comments/delete/{id}', 'CommentsController@destroy');
      Route::post('comments/massapprove/', 'CommentsController@massApprove');
      Route::post('comments/massdelete/', 'CommentsController@massDestroy');
    });
});

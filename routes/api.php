<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'ApiController@login');

Route::post('register', 'ApiController@register');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'ApiController@logout');

    Route::get('tasks', 'TaskController@index');

    Route::get('tasks/{id}', 'TaskController@show');

    Route::post('tasks', 'TaskController@store');

    Route::put('tasks/{id}', 'TaskController@update');
    
    Route::delete('tasks/{id}', 'TaskController@destroy');
});

//home
Route::get('/home', 'ArticleController@index')->name('home');

Route::get('/', 'ArticleController@index');

//article
Route::group(['prefix' => 'article'], function () {
    Route::get('/create', 'ArticleController@create');

    Route::post('/store', 'ArticleController@store');

    Route::get('/{id}/edit', 'ArticleController@edit');

    Route::post('/update/{id}', 'ArticleController@update');

    Route::post('/{id}/delete', 'ArticleController@destroy');

    Route::get('/', 'ArticleController@index');

    Route::get('/catagory/{catagory}', 'ArticleController@catagory');

    Route::get('/search', 'ArticleController@search');

    Route::get('/user/{name}', 'ArticleController@user');

    Route::get('/{id}', 'ArticleController@show');
});

// message
Route::group(['prefix' => 'message'], function () {
    Route::post('/{article_id}', 'MessageController@store');

    Route::get('/delete/{article_id}/{message_id}', 'MessageController@destroy');
});

//role
Route::group(['prefix' => 'admin'], function () {
    Route::get('/index', 'RoleController@index')->middleware(['master.role']);

    Route::get('/role/{id}/upgrade', 'RoleController@roleUpgrade');

    Route::get('/role/{id}/downgrade', 'RoleController@roleDowngrade');
});

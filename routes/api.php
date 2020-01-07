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

Route::/*middleware('auth:api')->*/get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'ApiController@login');

Route::post('/register', 'ApiController@register');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::post('/logout', 'ApiController@logout');
});

//home
Route::get('/home', 'ArticleController@index')->name('home');

Route::get('/', 'ArticleController@index');

//article
Route::group(['prefix' => 'article', 'middleware' => 'auth.jwt'], function () {
    Route::post('/store', 'ArticleController@store');

    Route::get('/{id}/edit', 'ArticleController@edit')->middleware('article.author.role');

    Route::post('/update/{id}', 'ArticleController@update')->middleware('article.author.role');

    Route::post('/{id}/delete', 'ArticleController@destroy')->middleware('article.author.role');

    Route::get('/', 'ArticleController@index');

    Route::get('/catagory/{catagory}', 'ArticleController@catagory');

    Route::get('/search', 'ArticleController@search');

    Route::get('/user/{name}', 'ArticleController@user');

    Route::get('/{id}', 'ArticleController@show');
});

// message
Route::group(['prefix' => 'message'], function () {
    Route::post('/{articleId}', 'MessageController@store');

    Route::get('/delete/{articleId}/{messageId}', 'MessageController@destroy')->middleware('message.author.role');
});

//role
Route::group(['prefix' => 'admin', 'middleware' => 'master.role' ], function () {
    Route::get('/index', 'RoleController@index');

    Route::get('/role/upgrade/{userId}', 'RoleController@roleUpgrade');

    Route::get('/role/{userId}/downgrade', 'RoleController@roleDowngrade');
});

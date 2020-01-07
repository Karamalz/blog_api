<?php

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

Route::post('/login', 'AuthController@login');

Route::post('/register', 'AuthController@register');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::post('/logout', 'AuthController@logout');
});

//home
Route::get('/home', 'ArticleController@index')->name('home');

Route::get('/', 'ArticleController@index');

//article
Route::group(['prefix' => 'article', 'middleware' => 'auth.jwt'], function () {
    Route::post('/store', 'ArticleController@store');

    Route::get('/edit/{articleId?}', 'ArticleController@edit')->middleware('article.author.role');

    Route::post('/update/{articleId?}', 'ArticleController@update')->middleware('article.author.role');

    Route::post('/delete/{articleId?}', 'ArticleController@destroy')->middleware('article.author.role');

    Route::get('/', 'ArticleController@index');

    Route::get('/catagory/{catagory}', 'ArticleController@catagory');

    Route::get('/search', 'ArticleController@search');

    Route::get('/user/{name}', 'ArticleController@user');

    Route::get('/{articleId?}', 'ArticleController@show');
});

// message
Route::group(['prefix' => 'message'], function () {
    Route::post('/{articleId?}', 'MessageController@store');

    Route::get('/delete/{messageId?}', 'MessageController@destroy')->middleware('message.author.role');
});

//role
Route::group(['prefix' => 'admin', 'middleware' => ['master.role', 'auth.jwt']], function () {
    Route::get('/index', 'RoleController@index');

    Route::get('/role/upgrade/{userId?}', 'RoleController@roleUpgrade');

    Route::get('/role/downgrade/{userId?}', 'RoleController@roleDowngrade');
});

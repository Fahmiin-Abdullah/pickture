<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'app');

Route::post('/register', 'Auth\RegisterController@register');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/profile/{id}', 'UserController@getUser');
Route::get('/profile/social/{id}', 'UserController@getSocial');
Route::post('/profile/update/{id}', 'UserController@update');

Route::get('/posts/{id}', 'PostController@getPosts');
Route::post('/post/create', 'PostController@create');
Route::get('/post/{id}', 'PostController@getPost');
Route::post('/post/update/{id}', 'PostController@update');
Route::post('/post/delete/{id}', 'PostController@delete');

Route::get('/categories', 'PostController@getCategories');
Route::get('/posts/category/{params}', 'PostController@getCategory');
Route::get('/discover', 'PostController@discover');
Route::post('/search/{query}', 'PostController@search');
Route::get('/search/{query}', 'PostController@search');

Route::get('/like/{id}', 'ActionsController@like');
Route::get('/isLiked/{id}', 'ActionsController@isLiked');
Route::get('/favourite/{id}', 'ActionsController@fav');
Route::get('/isFaved/{id}', 'ActionsController@isFaved');

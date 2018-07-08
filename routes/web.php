<?php

use App\Category;

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

Route::get('/', function() {
	$categories = Category::all();

	return view('app')
			->with('categories', $categories);
});

Route::post('/register', 'Auth\RegisterController@register');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/profile/{id}', 'UserController@getUser');
Route::get('/profile/social/{id}', 'UserController@getSocial');
Route::post('/profile/update/{id}', 'UserController@update');

Route::get('/posts/{id}', 'PostController@getPosts');
Route::post('/post/create', 'PostController@create');
Route::get('/post/{id}', 'PostController@getPost');

Route::get('/discover', 'PostController@discover');
Route::get('/posts/category/{page}', 'PostController@getCategory');
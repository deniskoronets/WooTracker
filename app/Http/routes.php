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

Route::get('/', 'Site\WelcomeController@index');

Route::get('/auth/login/', 'Auth\AuthController@getLogin');
Route::post('/auth/login/', 'Auth\AuthController@postLogin');

Route::group(['namespace' => 'Site', 'middleware' => 'auth'], function() {

	Route::group(['prefix' => '/projects/'], function() {
		Route::get('/', 'ProjectController@index');
		Route::any('/create/', 'ProjectController@create');
		Route::get('/{id}', 'ProjectController@tasks')->where('id', '[0-9]+');
		Route::get('/{id}/delete', 'ProjectController@delete')->where('id', '[0-9]+');
		Route::any('/{id}/edit', 'ProjectController@edit')->where('id', '[0-9]+');
	});

	Route::group(['prefix' => '/tasks/'], function() {
		Route::any('/create/project-{projectId}', 'TaskController@create')->where('projectId', '[0-9]+');
		Route::get('/{id}', 'TaskController@view')->where('id', '[0-9]+');
		Route::get('/{id}/delete', 'TaskController@delete')->where('id', '[0-9]+');
		Route::any('/{id}/edit', 'TaskController@edit')->where('id', '[0-9]+');
		Route::any('/{id}/add-comment', 'TaskController@addComment')->where('id', '[0-9]+');
		Route::any('/edit-comment/{id}', 'TaskController@editComment')->where('id', '[0-9]+');
		Route::any('/delete-comment/{id}', 'TaskController@deleteComment')->where('id', '[0-9]+');
	});

	Route::group(['prefix' => '/users/'], function() {
		Route::get('/{id}', 'UserController@view')->where('id', '[0-9]+');
	});
});

Route::group(['prefix' => '/admin/', 'namespace' => 'Admin', 'middleware' => 'admin'], function() {
	Route::any('/', 'DashController@index');

	Route::group(['prefix' => '/projects/'], function() {
		Route::get('/', 'ProjectController@index');
		Route::any('/create/', 'ProjectController@create');
		Route::get('/{id}', 'ProjectController@tasks')->where('id', '[0-9]+');
		Route::get('/{id}/delete', 'ProjectController@delete')->where('id', '[0-9]+');
		Route::any('/{id}/edit', 'ProjectController@edit')->where('id', '[0-9]+');
	});
});
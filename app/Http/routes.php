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

Route::get('/', 'WelcomeController@index');

Route::get('/auth/login/', 'Auth\AuthController@getLogin');
Route::post('/auth/login/', 'Auth\AuthController@postLogin');

// Test create:
Route::get('/auth/create/', 'Auth\AuthController@testCreate');

Route::group(['prefix' => '/projects/'], function() {
	Route::get('/', 'ProjectController@index');
	Route::get('/create/', 'ProjectController@index');
});

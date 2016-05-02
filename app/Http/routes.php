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

Route::get('/book', 'BookController@index');

Route::get('/scrape', 'ScrapeController@scrape');

Route::get('/skills', 'SkillController@index');

Route::resource('api/book', 'APIController',
	['except' => 'edit', 'create']);

Route::get('/', 'BookController@index');
<?php

session_start();

Route::get('/', function(){
	return Redirect::to('/index');
});

Route::get('/login',array('as'=>'login','uses'=>'UserController@login'));
Route::post('/postLogin',array('as'=>'login','uses'=>'UserController@postLogin'));
Route::get('/logout',array('uses'=>'UserController@logout'));

Route::get('/index', array('uses'=>'UserController@index'));
Route::get('/users', function(){
	return Redirect::to('/index');
});
Route::post('/search', 'UserController@search'); 
Route::post('/update', 'UserController@update'); 
Route::get('/search', 'UserController@search'); 
Route::any('/process/{id?}', 'ProcessController@process'); 
Route::any('/email', 'UserController@email');
Route::get('/userprofile', 'UserController@userprofile');
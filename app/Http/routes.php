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

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::get('department', 'DepartmentController@index');
Route::post('department_submit',['as'=>'department_submit','uses'=>'DepartmentController@departmentSubmit']);
Route::get('project', 'ProjectController@index');
Route::post('project_submit',['as'=>'project_submit','uses'=>'ProjectController@projectSubmit']);
Route::get('user_list',['as'=>'user_list','uses'=>'ProjectController@userList']);
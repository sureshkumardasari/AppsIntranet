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


// for adding tasks to the candidate by admin.

Route::get('addtask','TaskController@index');
Route::post('addtask','TaskController@add');
Route::post('projectlist/{id}',['as'=>'project_list','uses'=>'TaskController@projectList']);


/*..... Department Routs  ....*/
Route::get('department', 'DepartmentController@display');
Route::post('department_submit',['as'=>'department_submit','uses'=>'DepartmentController@departmentSubmit']);
Route::get('department_create','DepartmentController@index');
Route::post('department_update/{id}','DepartmentController@update');
Route::get('department/{id}','DepartmentController@destroy');
Route::get('department/{id}/edit','DepartmentController@edit');

/*..... Project Routs  ....*/
Route::get('project', 'ProjectController@index');
Route::post('project_submit',['as'=>'project_submit','uses'=>'ProjectController@projectSubmit']);
Route::get('edit/{id}','ProjectController@edit');
Route::post('update/{id}','ProjectController@update');
Route::get('delete/{id}','ProjectController@destroy');
Route::get('user_list',['as'=>'user_list','uses'=>'ProjectController@userList']);
Route::get('project_view',['as'=>'project_view','uses'=>'ProjectController@show']);

/*...... User Routs ......*/
Route::get('users', 'UserController@show');
Route::get('users/edit/{id}','UserController@edit');
Route::get('users/delete/{id}','UserController@destroy');
Route::post('users/update/{id}','UserController@update');
Route::get('users/profile/{id}','UserController@profile');
Route::post('create','UserController@create');

/*.......my routes..*/

// for adding tasks to the candidate by admin.

Route::get('addtask','TaskController@index');
Route::post('addtask','TaskController@add');
Route::post('projectlist/{id}',['as'=>'project_list','uses'=>'TaskController@projectList']);
Route::post('modulelist/{id}',['as'=>'module_list','uses'=>'TaskController@modulelist']);

/*for getting the timesheet of the user...*/

Route::get('timesheet','TimesheetController@index');

//module creation
Route::get('modulecreation','ProjectModuleController@index');
Route::post('addmodule',['as'=>'addmodule','uses'=>'ProjectModuleController@add']);
//getting task list based on project and module

Route::post('tasklist/{project_id}/{module_id}','TaskController@taskList');
Route::post('timesheetsubmit','TimeSheetController@add');
Route::get('timesheet_display','TimeSheetController@display_timesheet');
Route::post('gettimesheetfilterdata','TimeSheetController@filter');


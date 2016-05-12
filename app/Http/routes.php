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
Route::get('homes', 'WelcomeController@userLogin');
Route::post('login_check',['as'=>'login_check','uses'=>'HomeController@userLoginCheck']);

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
Route::post('userlist_project/{id}',['as'=>'userlist_project','uses'=>'ProjectController@userListProject']);
Route::get('project_view',['as'=>'project_view','uses'=>'ProjectController@show']);

/*...... User Routs ......*/
Route::get('users', 'UserController@show');
Route::get('users/edit/{id}','UserController@edit');
Route::get('users/delete/{id}','UserController@destroy');
Route::post('users/update/{id}','UserController@update');
Route::get('users/profile/{id}','UserController@profile');
Route::post('create','UserController@create');


// for adding tasks to the candidate by admin.
Route::get('task','TaskController@display');
Route::get('addtask','TaskController@index');
Route::post('addtask','TaskController@add');
Route::post('project_list/{id}',['as'=>'project_list','uses'=>'TaskController@project_List']);
Route::post('modulelist/{id}',['as'=>'module_list','uses'=>'TaskController@modulelist']);
Route::post('taskupdate/{id}','TaskController@update');
Route::get('task/{id}','TaskController@destroy');
Route::get('task/{id}/edit','TaskController@edit');

/*for getting the timesheet of the user...*/

Route::get('timesheet','TimesheetController@index');

//module Routes
Route::get('module', 'ProjectModuleController@display');
Route::get('modulecreation','ProjectModuleController@index');
Route::post('addmodule',['as'=>'addmodule','uses'=>'ProjectModuleController@add']);
Route::post('module/{id}','ProjectModuleController@update');
Route::get('module/{id}','ProjectModuleController@destroy');
Route::get('module/{id}/edit','ProjectModuleController@edit');

//getting task list based on project and module

Route::post('tasklist/{project_id}/{module_id}','TaskController@taskList');
Route::post('timesheetsubmit','TimeSheetController@add');
Route::get('timesheet_display',['as'=>'timesheet_display','uses'=>'TimeSheetController@display_timesheet']);
Route::post('gettimesheetfilterdata','TimeSheetController@filter');
Route::get('timesheet_edit/{timesheet_id}','TimeSheetController@edit');
Route::post('timesheet_display','TimeSheetController@display_timesheet');
Route::post('timesheet_update','TimeSheetController@update');
Route::get('UsersTimesheet','TimeSheetController@usertimesheet');
Route::post('UsersTimesheet/{id}','TimeSheetController@projectlist');

/*Roles*/
Route::get('home_project_lead', 'WelcomeController@projectLead');
Route::get('home_project_manager', 'WelcomeController@projectManager');
Route::post('user_profile',['as'=>'user_profile','uses'=>'HomeController@userProfile']);
Route::get('user_profile',['as'=>'user_profile','uses'=>'HomeController@userDetails']);


// home page
Route::get('validate', array('before' => 'auth', function()
{
 	if(Entrust::hasRole('User')) {
		return View::make('home_user');
	}
	else if(Entrust::hasRole('Admin')) {
		return View::make('home_admin');
	}
	else if(Entrust::hasRole('Project Lead')) {
		return View::make('home_project_lead');
	}
	else if(Entrust::hasRole('Project Manager')) {
		return View::make('home_project_manager');
	}
	else {
		Auth::logout();
		return Redirect::to('/homes')
			->with('errors', 'You don\'t have access!');
	}

	return App::abort(403);
}));

// logout route
Route::get('logout', array('before' => 'auth', function()
{
	dd('logout');
	Auth::logout();
	return Redirect::to('/')
		->with('flash_notice', 'You are successfully logged out.');
}));

Route::post('task/{id}','TaskController@task');
Route::get('completedtask','TaskController@completedtask');
Route::get('status/{id}','HomeController@status');
Route::post('userlist/{department_id}/{project_id}/{task_id}','UserController@userlist');
Route::get('profile','HomeController@profile_view');
Route::post('profileupdate/{id}','HomeController@profile_update');

//Excel Routes....
Route::get('downloadExcelfordepartment/{type}', 'DepartmentController@downloadExcel');

Route::get('downloadExcelforproject/{type}', 'ProjectController@downloadExcel');

Route::get('downloadExcelforusers/{type}', 'UserController@downloadExcel');

Route::get('downloadExcelforprojectmodule/{type}', 'ProjectModuleController@downloadExcel');

Route::get('downloadExcelfortask/{type}', 'TaskController@downloadExcel');

Route::get('downloadExcelfortask/{type}', 'TaskController@downloadExcel');
Route::get('downloadExcelfortimesheet/{type}','TimeSheetController@downloadExcel');



//Client Routes
Route::post('client','ClientController@create');
Route::get('clientcreate','ClientController@index');
Route::get('clientview', 'ClientController@display');
Route::get('client/{id}/edit','ClientController@edit');
Route::get('delete/{id}','ClientController@destroy');
Route::post('update_client/{id}','ClientController@update');
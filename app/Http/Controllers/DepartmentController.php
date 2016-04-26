<?php namespace App\Http\Controllers;

use App\Department;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class DepartmentController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	public function index()
	{
		return view('department');
	}
	public function departmentSubmit(){
	$depart_list=Input::All();
   		$depart = Department::create([
			'name' => $depart_list['depart_name'],
  			'description' => $depart_list['depart_description'],
		]);
		\Session::flash('success','Department successfully added.');
 		return Redirect::back();
  	}

}

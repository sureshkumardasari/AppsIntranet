<?php namespace App\Http\Controllers;

use App\Department;
use App\ProjectUser;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Project;
use App\User;
class ProjectController extends Controller {

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

		return view('project');
	}
	public function projectSubmit(){
 		$project_list=Input::All();
//		dd($project_list);
		$user=[];
		$user[]=$project_list['userids'];
   		$depart_list = Department::where('name', '=', $project_list['user_depart_name'])->first();
 		$project = Project::create([
			'name' => $project_list['pro_name'],
			'description' => $project_list['pro_description'],
			'department_id' => $depart_list['id'],
		]);
		$pro_list = Project::where('name', '=', $project_list['pro_name'])->first();
		$lastInsertedId= $pro_list['id'];
 		if($project){
			foreach($user as $users){
				print_r($users['']);
//				$project_user=ProjectUser::create([
//					'user_id' => $users,
//					'project_id' =>$lastInsertedId,
//				]);
			}
			dd('exit');
		}

 		\Session::flash('success','Project successfully added.');
		return Redirect::back();
	}
	public function userList(){
		$user_list=User::get();
		$res=[];
		foreach($user_list as $list){
			$res[]=array("text"=>$list['first_name'],"value"=>$list['first_name']);
 		}
		$json = json_encode($res);
		//dd($json);
		exit($json);
	}

}

<?php namespace App\Http\Controllers;

use App\Department;
use App\ProjectDepartment;
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
		$user=[];
		$depart=[];
		$depart_list = Department::where('name', '=', $project_list['user_depart_name'])->first();
		$project=new Project;
		$project->name=$project_list['pro_name'];
		$project->description=$project_list['pro_description'];
//		$project->department_id=$depart_list['id'];
		if($project->save()){
			$depart=$project_list['user_depart_name'];
			$user=$project_list['userids'];
			$lastInsertedId= $project->id;
			foreach($depart as $departs){
				$project_depart=new ProjectDepartment();
				$project_depart->project_id=$lastInsertedId;
				$project_depart->depart_id=$departs;
				$project_depart->save();
			}
			foreach($user as $users){

				$project_user=new ProjectUser;
				$project_user->user_id=$users;
				$project_user->project_id=$lastInsertedId;
				$project_user->save();
			}
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
		exit(json_encode($res));
	}

}

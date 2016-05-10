<?php namespace App\Http\Controllers;

use App\Department;
use App\ProjectDepartment;
use App\ProjectUser;
use App\Http\Requests\ProjectRequest;
use Illuminate\Support\Facades\Input;
use App\Project;
use App\User;
use Validator;
use Redirect;
use App\UserDepartments;
class ProjectController extends Controller
{

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

	public function index(){
		return view('project');
	}
	public function projectSubmit()
	{

		$postData = Input::all();
		$messages = [
			'name.required' => 'Enter name of the project',
			'description.required' => 'You need a description',
			'user_depart_name.required' => 'Department name is required',
		];
		$rules = [
			'name' => 'required|min:2|unique:projects',
			'description' => 'required|min:10',
			'user_depart_name' => 'required'


		];
		$validator = Validator::make($postData, $rules, $messages);
		if ($validator->fails()) {
			return Redirect('project')->withInput()->withErrors($validator);
		} else {
//
			$project_list = Input::All();
			$project = new Project;
			$project->name = $project_list['name'];
			$project->description = $project_list['description'];
			$project->save();

			if (isset($project_list['user_depart_name'])) {
				$depart = $project_list['user_depart_name'];
				if (isset($project_list['lead'])) {
					$leads = $project_list['lead'];
				} else $leads = array();
				if (isset($project_list['manager'])) {
					$manager = $project_list['manager'];
				} else $manager = array();
				if (isset($project_list['user'])) {
					$user_list = $project_list['user'];
				} else $user_list = array();
				$user = array_merge($leads, $manager, $user_list);


				$lastInsertedId = $project->id;
				foreach ($depart as $departs) {
					$project_depart = new ProjectDepartment();
					$project_depart->project_id = $lastInsertedId;
					$project_depart->depart_id = $departs;
					$project_depart->save();
				}
				foreach ($user as $users) {

					$project_user = new ProjectUser;
					$project_user->user_id = $users;
					$project_user->project_id = $lastInsertedId;
					$project_user->save();
				}
			}
			return Redirect::route('project_view');
		}
	}

 	public function edit($id)
	{
		$projects = \DB::table('projects')->where('id', $id)->first();
//
		$departments=ProjectDepartment::where('project_id',$id)->select('depart_id')->get();

		//for project leads.........

		$project_leads=ProjectUser::join('users','projects_users.user_id','=','users.id')
			->select('users.id','users.first_name')->where('projects_users.project_id',$id)
			->where('users.role_id',3)->get();

		//for project managers........

		$project_managers=ProjectUser::join('users','projects_users.user_id','=','users.id')
			->select('users.id','users.first_name')->where('projects_users.project_id',$id)
			->where('users.role_id',4)->get();

		//for project users..........

		$project_users=ProjectUser::join('users','projects_users.user_id','=','users.id')
			->select('users.id','users.first_name')->where('projects_users.project_id',$id)
			->where('users.role_id',2)->get();

		return view('edit', compact('projects','departments','project_leads','project_managers','project_users'));
	}
	public function update($id)
	{

		$projects = Project::find($id);
		//Update Query
		$post=Input::all();
		$validator=Validator::make($post,[
				'description' => 'required|min:10',
				'user_depart_name' => 'required']
		);
		if ($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}
		unset($projects['_token']);

		$record = Project::where('id',$id)->update([
				'description'=>$post['description'],
		]);

		ProjectDepartment::where('project_id',$id)->delete();
		ProjectUser::where("project_id",$id)->delete();
		if (isset($post['user_depart_name'])) {
			$depart = $post['user_depart_name'];
			if (isset($post['lead'])) {
				$leads = $post['lead'];
			} else $leads = array();
			if (isset($post['manager'])) {
				$manager = $post['manager'];
			} else $manager = array();
			if (isset($post['user'])) {
				$user_list = $post['user'];
			} else $user_list = array();
			$user = array_merge($leads, $manager, $user_list);


			$lastInsertedId = $id;

			foreach ($depart as $departs) {
				$project_depart = new ProjectDepartment();
				$project_depart->project_id = $lastInsertedId;
				$project_depart->depart_id = $departs;
				$project_depart->save();
			}



			foreach ($user as $users) {

				$project_user = new ProjectUser;
				$project_user->user_id = $users;
				$project_user->project_id = $lastInsertedId;
				$project_user->save();
			}



		}

		//Redirecting to index() method of BookController class
		return redirect('project_view');
	}
	public function destroy($id)
	{
		$users = ProjectUser::where('project_id', $id)->count();

		if ($users == 0) {
			Project::find($id)->delete();
			\Session::flash('flash_message', 'Deleted.');
			return redirect('project_view');

		} else {
			\Session::flash('flash_message_failed', 'Can not Delete this Project.');
			return Redirect::back();

		}
	}
	public function userList(){
		$user_list=User::get();
		$res=[];
		foreach($user_list as $list){
			$res[]=array("text"=>$list['first_name'],"value"=>$list['first_name']);
		}
		exit(json_encode($res));
	}
	public function show()
	{
		$projects=Project::get();
		return view('project_view',compact('projects'));
	}

	public function userListProject($id)
	{
		$imp = explode(',', $id);
		$lead_users = UserDepartments::join('users', 'user_departments.user_id', '=', 'users.id')
			->whereIn('user_departments.depart_id', $imp)
			->select('users.id', 'users.first_name', 'users.role_id')
			->groupBy('id')
			->orderBy('role_id', 'first_name')
			->get();
//
		if (sizeof($lead_users) == 0) {
			return null;
		}
		return $lead_users;
	}
}

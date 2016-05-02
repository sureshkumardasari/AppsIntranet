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

	public function index(){
		return view('project');
	}
	public function projectSubmit(){

		$postData = Input::all();
		$messages = [
				'name.required' => 'Enter name of the project',
				'description.required' => 'You need a description',
				'user_depart_name'=>'department name is required',
				'userids'=>'userid is required'

		];
		$rules = [
				'name'=>'required|min:2|unique:projects',
				'description'=>'required|min:10',
				'user_depart_name'=>'required',
				'userids'=>'required'

		];
		$validator = Validator::make($postData, $rules, $messages);
		if ($validator->fails())
		{
			return Redirect('project')->withInput()->withErrors($validator);
		}
		else {
			$inputa=Input::all();

			$project = Project::create([
					'name' => $inputa['name'],
					'description' => $inputa['description'],
			]);



			return Redirect::route('project_view');
		}
		/*$project_list=Input::All();
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
		return Redirect::back();*/

		//Project::create($inputa);
		// return redirect('project_view');
	}
	public function edit($id)
	{
		$projects=\DB::table('projects')->where('id',$id)->first();
		return view('edit',compact('projects'));
	}
	public function update($id)
	{

		$projects = Project::find($id);
		//Update Query
		$post=Input::all();
		$validator=Validator::make($post,[
						'name'=>'required|min:2|unique:projects',
						'description'=>'required|min:10']
		);
		if ($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}
		unset($projects['_token']);

		$record = Project::where('id',$id)->update([
				'name'=>$post['name'],
				'description'=>$post['description'],
		]);

		//Redirecting to index() method of BookController class
		return redirect('project_view');
	}
	public function destroy($id)
	{
		Project::find($id)->delete();
		return redirect('project_view');
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

}

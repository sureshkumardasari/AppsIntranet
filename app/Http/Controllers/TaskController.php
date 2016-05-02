<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\projectModules;
use Illuminate\Http\Request;
use App\User;
use App\ProjectUser;
use App\ProjectDepartment;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Tasks;
use Validator;
use Session;
use App\Project;



class TaskController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$users=User::select('id','username')->get();
		$projects=Project::select('id','name')->get();
 		return view('assign_task',compact('users','projects'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	public function projectList($id){
	$a=	ProjectUser::join('projects','projects_users.project_id','=','projects.id')
			->where('projects_users.user_id','=',$id)
			->select('projects.id','name')
			->get();
  		return $a;
	}
	public function moduleList($id){
		$a=projectModules::where('project_id',$id)->select('id','name')->get();
  		return $a;
	}

	/*----------getting the list of the tasks that are assosciated with the specified project and the module-------*/
	public function taskList($projectid=null,$moduleid=null){
		$task_list=Tasks::select('id','task_title')->where('project_id',$projectid)->where('module_id',$moduleid)->get();
return $task_list;
	}
	public function add(){
		$data=Input::All();
 		$validator=Validator::make($data,['project_id'=>'required','module_id'=>'required','task_title'=>'required','task_description'=>'required'
			,'user_id'=>'required','date'=>'required']);
		if($validator->fails())
		{
			Session::flash('fail','please provide all the fileds');
			return Redirect::back()->withInput();
		}
		//dd($data);
		$data['date']=date('y-m-d',strtotime($data['date']));
		$exec=Tasks::create($data);
		Session::flash('success','Task added successfully');
		return Redirect::back();

	}

}

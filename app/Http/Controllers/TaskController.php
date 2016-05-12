<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\projectModules;
use App\TimeSheet;
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
use Auth;
use Excel;



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
		$task=Tasks::find($id);
		$users=User::get();
		return view('task_edit',compact('task','users'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$task=Tasks::find($id);
		$post=Input::all();
		$validator=Validator::make($post,[
						'task_description'=>'required|min:5',
						'user_id'=>'required'
				]
		);
		if ($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}
		unset($post['_token']);
		$record = Tasks::where('id',$id)->update([
				'task_title'=>$post['task_title'],
				'task_description'=>$post['task_description'],
				'date'=>date('y-m-d',strtotime($post['date'])),
				'user_id'=>$post['user_id'],

		]);
		return Redirect::to('task');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		/*Tasks::find($id)->delete();
		return Redirect::to('task');*/
		/*$user_department = User::where('id', $id)->count();*/
		/*$project =ProjectUser::where('project_id',$id)->count();
		dd($id);
		$projectuser =ProjectUser::where('user_id',$id)->count();*/
		$users=User::select('id')->count();
		$projects=Project::select('id')->count();
		if($projects == null && $users == null)
		{
		Tasks::find($id)->delete();
		 \Session::flash('message', 'Deleted!');
		 return Redirect::to('task');
		}
		else
		{
			\Session::flash('alert-class', 'Cannot Delete this Task');
		
		return Redirect::back();

		}
	}
	public function projectList($id){
		$projects=	ProjectUser::join('projects','projects_users.project_id','=','projects.id')
				->where('projects_users.user_id','=',$id)
				->select('projects.id','name')
				->get();
		return $projects;
	}
	public function moduleList($id){
		$modules=projectModules::where('project_id',$id)->select('id','name')->get();
		return $modules;
	}

	/*----------getting the list of the tasks that are assosciated with the specified project and the module-------*/
	public function taskList($projectid=null,$moduleid=null){
		$task_list=Tasks::select('id','task_title')->where('project_id',$projectid)->where('module_id',$moduleid)->get();
		return $task_list;
	}
	public function add(){
		$data=Input::All();


		$validator=Validator::make($data,[
						'project_id'=>'required','module_id'=>'required','task_title'=>'required|unique:tasks','task_description'=>'required'
					,'user_id'=>'required','date'=>'required'
				]
		);
		if ($validator->fails()){
			return Redirect::back()->withInput()->withErrors($validator);
		}

		//dd($data);
		$data['date']=date('y-m-d',strtotime($data
		['date']));
		$exec=Tasks::create($data);
		Session::flash('success','Task added successfully');
		return Redirect::to('task');

	}

	public function display()
	{
		$tasks=Tasks::get();
		return view('task_display',compact('tasks'));
	}

	public function completedtask()
	{
		return view('dashboard_taskdisplay');
	}
	public function task($id)
	{
		if($id==4)
		{
			$user_data_task=Tasks::get();
			return view('Dashboard',compact('user_data_task'));
		}
		else
		{
			$users=Auth::user();
			$z=$users->id;
			$tasks=TimeSheet::where('status','=',$id)->get();
			$c=array();
			foreach($tasks as $task)
				array_push($c,$task->task_id);
			$user_data_task=TimeSheet::join('tasks','time_sheets.task_id','=','tasks.id')
					->wherein('time_sheets.task_id',$c)
					->where('tasks.user_id','=',$z)
					->select('task_title','task_description')->get();

			return view('Dashboard',compact('tasks','user_data_task'));
		}

	}
	public function project_list($id=null){
		$projects=	ProjectDepartment::join('projects','projects_depart.project_id','=','projects.id')
			->where('projects_depart.depart_id','=',$id)
			->select('projects.id','projects.name')
			->get();
		return $projects;

	}


	public function downloadExcel($type)
	{
		$data = Tasks::select('task_title','task_description')->get()->toArray();
		return Excel::create('tasktlist', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->download($type);
	}

}

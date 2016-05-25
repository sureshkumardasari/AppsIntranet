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
		$messages=[
					
						'task_description.required'=>'Task Description is required',
						'user_id.required'=>'Please choose a User',
        ];
		$rules=[
						
						'task_description'=>'required',
						'user_id'=>'required','date'=>'required',
                        'task_title'=>'required|max:255|unique:tasks,task_title,' . $id
		];
		$validator=Validator::make($post,$rules,$messages);
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
		/*dd($id);*/
		$users=User::select('id')->count();
		$projects=Project::select('id')->count();
		if($projects == null && $users == null)
		{
		Tasks::find($id)->delete();
		 \Session::flash('message', 'Deleted!');
		 return Redirect::back();
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
        if($moduleid > 0 ) {
            $task_list = Tasks::select('id', 'task_title')->where('project_id', $projectid)->where('module_id', $moduleid)->get();
        }
        else {
            $task_list = Tasks::select('id', 'task_title')->where('project_id', $projectid)->get();
        }
        return $task_list;
	}

    public function task_List($projectid=null){
        $task_list=Tasks::select('id','task_title')->where('project_id',$projectid)->get();
        return $task_list;
    }

	public function add(){
		$data=Input::All();
		$messages=[
					    'project_id.required'=>'Please choose a project',
						'task_title.required'=>'Please give  a task title',
						'task_description.required'=>'Task Description is required',
						'user_id.required'=>'Please choose a User',
						'date.required'=>'Please mention Date',
		];
		$rules=[
						'project_id'=>'required',
						'task_title'=>'required|unique:tasks',
						'task_description'=>'required',
						'user_id'=>'required','date'=>'required'
		];
		$validator=Validator::make($data,$rules,$messages);
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
        $user_data_task=Tasks::select('task_title','task_description','id')->get();
		$tasks=Tasks::get();
		return view('dashboard_taskdisplay',compact('tasks'))->nest("tasklist","Dashboard",compact('user_data_task') );
	}

	public function completedtask()
	{
        return view('dashboard_taskdisplay');
	}
	public function task($projectid,$statusid)
	{
		if($statusid==4 && $projectid==0)
		{
			$user_data_task=Tasks::select('task_title','task_description','id')->get();
			return view('Dashboard',compact('user_data_task'));
		}
        elseif($statusid==4 && $projectid !=0)
        {
            $user_data_task=Tasks::select('task_title','task_description','id')
                ->where('project_id',$projectid)
                ->get();
            return view('Dashboard',compact('user_data_task'));   
        }
		else
		{
			$users=Auth::user();
			$z=$users->id;
			$tasks=Tasks::where('status','=',$statusid)
					->get();
			$c=array();
			foreach($tasks as $task)
				array_push($c,$task->id);
			$user_data_task=Tasks::select('task_title','task_description','id')
					->wherein('id',$c)
                    ->where('project_id',$projectid)
					->get();
			return view('Dashboard',compact('tasks','user_data_task'));
		}

	}

    public function project_task($id)
    {
        $user_data_task=Tasks::select('task_title','task_description','id')
            ->where('project_id',$id)
            ->get();
        return view('Dashboard',compact('user_data_task'));
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
		$data = Tasks::select('Task_Title','Task_Description')->get()->toArray();
		return Excel::create('tasktlist', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->download($type);
	}
public function viewlog($id)
{
    //$task=Tasks::find($id);
    $creat=Tasks::join('projects','Tasks.project_id','=','projects.id')
        ->join('project_modules','Tasks.module_id','=','project_modules.id','left')
        ->select('projects.name as project_name','project_modules.name as module_name','Tasks.task_title','Tasks.task_description')
        ->where('Tasks.id','=',$id)
        ->get();
    //dd($creat);
    $timesheet = TimeSheet::join('users','time_sheets.user_id','=','users.id')
        ->select('users.username','time_sheets.updated_at','time_sheets.hours','time_sheets.minutes','time_sheets.status','time_sheets.comment')
        ->where('time_sheets.task_id','=',$id)
		->orderBy('time_sheets.updated_at','desc')
        ->get();
    //dd($timesheet);
    return view('task_view',compact('timesheet','creat'));
}
}
